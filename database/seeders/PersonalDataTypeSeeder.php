<?php

namespace Database\Seeders;

use App\Models\PersonalDataType;
use Illuminate\Database\Seeder;

class PersonalDataTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(string $userId = null): void
    {
        if (!$userId) {
            $this->command->warn('No user ID provided. Skipping personal-data-processed seeding.');
            return;
        }

        $personalDataTypeList = [
            'Name',
            'Adresse',
            'Telefonnummer',
            'E-Mail-Adresse',
            'Geburtsdatum',
            'Staatsangehörigkeit',
            'Personalausweisnummer',
            'Internetadresse',
            'Faxnummer',
            'Lebenslauf',
            'Schulabschluss',
            'Berufsabschluss',
            'Studium',
            'Zeugnisse',
            'Positionsdaten',
            'Daten zu beruflichen Fortbildungen',
            'Termindaten',
            'Führerscheindaten',
            'Arbeitszeiten',
            'Lohn- und Gehaltsdaten',
            'Angaben zu Steuerklassen',
            'Familienstand',
            'Religionszugehörigkeit',
            'Urlaubszeiten',
            'Krankheitstage',
            'Daten zu Vorstrafen bzw. Eintragungen im Bundeszentralregister',
            'Kontodaten',
            'Vertragsdaten',
            'Abrechnungsinformationen',
            'Rechnungsanschrift',
            'Steueridentifikationsnummer',
            'Versicherungsdaten',
            'Umsatzdaten',
            'Daten zu gekauften Waren oder Dienstleistungen',
            'Biometrische Daten',
            'Bilddaten / Videodaten',
            'Erkrankungen (Spielsucht)',
            'Audio- und Sprachdaten',
            'IP-Adresse',
            'Nutzungshistorie',
            'Kommunikationsdaten / Nachrichteninhalte (Chat-Verläufe)',
            'Telekommunikationsdaten',
        ];

        foreach ($personalDataTypeList as $name) {
            PersonalDataType::query()->create([
                                                   'data_type' => $name,
                                                   'user_id' => $userId,
                                               ]);
        }
    }
}
