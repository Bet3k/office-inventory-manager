import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import Layout from '@/layouts/questionnaire-layout';
import { Head, router } from '@inertiajs/react';
import { useState } from 'react';

export default function Create() {
    const [answers, setAnswers] = useState<Record<string, Record<string, any>>>({});

    const [values, setValues] = useState({
        company: '',
        name: '',
    });

    function handleChange(e) {
        const key = e.target.id;
        const value = e.target.value;
        setValues((values) => ({
            ...values,
            [key]: value,
        }));
    }

    function handleSubmit(e) {
        e.preventDefault();
        router.post(route('questionnaire.store'), {
            ...values,
            answers,
        });
    }

    const handleCheckbox = (questionId: string, field: string, checked: boolean) => {
        setAnswers((prev) => ({
            ...prev,
            [questionId]: {
                ...prev[questionId],
                [field]: checked,
            },
        }));
    };

    const handleTextarea = (questionId: string, e: React.ChangeEvent<HTMLTextAreaElement>) => {
        setAnswers((prev) => ({
            ...prev,
            [questionId]: {
                ...prev[questionId],
                custom_category: e.target.value,
            },
        }));
    };

    return (
        <Layout>
            <Head title="Questionnaire" />
            <form className="h-full w-full" onSubmit={handleSubmit}>
                <div className="flex gap-6">
                    <div className="grid w-full gap-2">
                        <Label htmlFor="name">Vorname / Nachname</Label>
                        <Input
                            autoFocus
                            required
                            tabIndex={1}
                            type="text"
                            id="name"
                            placeholder="Vorname / Nachname"
                            value={values.name}
                            onChange={handleChange}
                        />
                    </div>
                    <div className="grid w-full gap-2">
                        <Label htmlFor="company">Firma / Abteilung</Label>
                        <Input
                            required
                            tabIndex={1}
                            type="text"
                            id="company"
                            placeholder="Bet3000 Entertainment"
                            value={values.company}
                            onChange={handleChange}
                        />
                    </div>
                </div>
                {/* Question 1 */}
                <div className="mt-4">
                    <h4 className="scroll-m-20 text-xl font-semibold tracking-tight">
                        1. Welche Kategorien von personenbezogenen Daten werden verarbeitet?
                        <div className="mt-2 flex flex-col gap-3">
                            {[
                                ['privatkundendaten', 'Privatkundendaten'],
                                ['geschaftskundendaten', 'Geschäftskundendaten'],
                                ['dvg', 'Daten von Geschäftspartnern'],
                                ['mitarbeiterdaten', 'Mitarbeiterdaten'],
                                ['behordendaten', 'Behördendaten'],
                                ['bewerberdaten', 'Bewerberdaten'],
                            ].map(([key, label]) => (
                                <div className="flex items-center gap-3" key={key}>
                                    <Checkbox
                                        id={key}
                                        checked={!!answers['question_1']?.[key]}
                                        onCheckedChange={(checked) => handleCheckbox('question_1', key, !!checked)}
                                    />
                                    <Label htmlFor={key}>{label}</Label>
                                </div>
                            ))}
                        </div>
                        <div className="mt-4">
                            <div className="grid w-full gap-3">
                                <Label htmlFor="question_one_text">
                                    Wenn die von Ihrer Abteilung bearbeiteten Kategorien nicht in der Liste enthalten sind, füllen Sie bitte die
                                    nachstehende Zeile aus:
                                </Label>
                                <Textarea
                                    id="question_1_text"
                                    value={answers['question_1']?.custom_category || ''}
                                    onChange={(e) => handleTextarea('question_1', e)}
                                    placeholder="Geben Sie hier Ihre Nachricht ein."
                                />
                            </div>
                        </div>
                    </h4>
                </div>
                {/* Question 2 */}
                <div className="mt-4">
                    <h4 className="scroll-m-20 text-xl font-semibold tracking-tight">
                        2. Welche personenbezogenen Daten innerhalb der unter Ziffer 1. genannten Kategorien werden verarbeitet?
                        <div className="mt-2 flex flex-col gap-3">
                            {[
                                ['name', 'Name'],
                                ['adresse', 'Adresse'],
                                ['telefonnummer', 'Telefonnummer'],
                                ['email', 'E-Mail-Adresse'],
                                ['geburtsdatum', 'Geburtsdatum'],
                                ['staatsangehörigkeit', 'Staatsangehörigkeit'],
                                ['personalausweisnummer', 'Personalausweisnummer'],
                                ['internetadresse', 'Internetadresse'],
                                ['faxnummer', 'Faxnummer'],
                                ['lebenslauf', 'Lebenslauf'],
                                ['schulabschluss', 'Schulabschluss'],
                                ['berufsabschluss', 'Berufsabschluss'],
                                ['studium', 'Studium'],
                                ['zeugnisse', 'Zeugnisse'],
                                ['positionsdaten', 'Positionsdaten'],
                                ['daten_beruflichen', 'Daten zu beruflichen Fortbildungen'],
                                ['termindaten', 'Termindaten'],
                                ['führerscheindaten', 'Führerscheindaten'],
                                ['arbeitszeiten', 'Arbeitszeiten'],
                                ['lohn', 'Lohn- und Gehaltsdaten'],
                                ['angaben', 'Angaben zu Steuerklassen'],
                                ['familienstand', 'Familienstand'],
                                ['religionszugehörigkeit', 'Religionszugehörigkeit'],
                                ['urlaubszeiten', 'Urlaubszeiten'],
                                ['krankheitstage', 'Krankheitstage'],
                                ['daten_vorstrafen', 'Daten zu Vorstrafen bzw. Eintragungen im Bundeszentralregister'],
                                ['kontodaten', 'Kontodaten'],
                                ['vertragsdaten', 'Vertragsdaten'],
                                ['abrechnungsinformationen', 'Abrechnungsinformationen'],
                                ['rechnungsanschrift', 'Rechnungsanschrift'],
                                ['steueridentifikationsnummer', 'Steueridentifikationsnummer'],
                                ['versicherungsdaten', 'Versicherungsdaten'],
                                ['umsatzdaten', 'Umsatzdaten'],
                                ['daten_gekauften', 'Daten zu gekauften Waren oder Dienstleistungen'],
                                ['biometrische', 'Biometrische Daten'],
                                ['bilddaten', 'Bilddaten / Videodaten'],
                                ['erkrankungen', 'Erkrankungen (Spielsucht)'],
                                ['audio', 'Audio- und Sprachdaten'],
                                ['ip_address', 'IP-Adresse'],
                                ['nutzungshistorie', 'Nutzungshistorie'],
                                ['kommunikationsdaten', 'Kommunikationsdaten / Nachrichteninhalte (Chat-Verläufe)'],
                                ['telekommunikationsdaten', 'Telekommunikationsdaten'],
                            ].map(([key, label]) => (
                                <div className="flex items-center gap-3" key={key}>
                                    <Checkbox
                                        id={key}
                                        checked={!!answers['question_2']?.[key]}
                                        onCheckedChange={(checked) => handleCheckbox('question_2', key, !!checked)}
                                    />
                                    <Label htmlFor={key}>{label}</Label>
                                </div>
                            ))}
                        </div>
                        <div className="mt-4">
                            <div className="grid w-full gap-3">
                                <Label htmlFor="question_2_text">
                                    Wenn die von Ihrer Abteilung verarbeiteten personenbezogenen Daten nicht in der Liste enthalten sind, füllen Sie
                                    bitte die nachstehende Zeile aus:
                                </Label>
                                <Textarea
                                    id="question_2_text"
                                    value={answers['question_2']?.custom_category || ''}
                                    onChange={(e) => handleTextarea('question_2', e)}
                                    placeholder="Geben Sie hier Ihre Nachricht ein."
                                />
                            </div>
                        </div>
                    </h4>
                </div>
                {/* Question 3 */}
                <div className="mt-4">
                    <h4 className="scroll-m-20 text-xl font-semibold tracking-tight">
                        3. Welche personenbezogenen Daten innerhalb der unter Ziffer 1. genannten Kategorien werden verarbeitet?
                        <Textarea
                            className="mt-2"
                            id="question_3_text"
                            value={answers['question_3']?.custom_category || ''}
                            onChange={(e) => handleTextarea('question_3', e)}
                            placeholder="Geben Sie hier Ihre Nachricht ein."
                        />
                    </h4>
                </div>
                {/* Question 4 */}
                <div className="mt-4">
                    <h4 className="scroll-m-20 text-xl font-semibold tracking-tight">
                        4. Zu welchen Zwecken werden diese personenbezogenen Daten verarbeitet (z.B. Abwicklung von Geschäftsvorfällen, Werbung)?
                        <Textarea
                            className="mt-2"
                            id="question_4_text"
                            value={answers['question_4']?.custom_category || ''}
                            onChange={(e) => handleTextarea('question_4', e)}
                            placeholder="Geben Sie hier Ihre Nachricht ein."
                        />
                    </h4>
                </div>
                {/* Question 5 */}
                <div className="mt-4">
                    <h4 className="scroll-m-20 text-xl font-semibold tracking-tight">
                        5. Welche Abteilungen innerhalb der IBA Entertainment Ltd. sind mit den unter Ziffer 3. genannten Verarbeitungsvorgängen
                        jeweils befasst?
                        <div className="mt-2 flex flex-col gap-3">
                            {[
                                ['geschäftsführung', 'Geschäftsführung'],
                                ['empfang', 'Empfang'],
                                ['einkauf', 'Einkauf'],
                                ['buchhaltung', 'Buchhaltung'],
                                ['aml', 'AML'],
                                ['responsible_gaming', 'Responsible Gaming'],
                                ['management', 'Management'],
                                ['marketing', 'Marketing & Services'],
                                ['hr', 'Personalabteilung - HR'],
                                ['rechtsabteilung', 'Rechtsabteilung'],
                                ['compliance', 'Compliance'],
                                ['support', 'Support'],
                                ['sportsbook', 'Sportsbook'],
                                ['onextwo', 'onextwo'],
                                ['it', 'IT'],
                                ['franchise', 'Franchise'],
                            ].map(([key, label]) => (
                                <div className="flex items-center gap-3" key={key}>
                                    <Checkbox
                                        id={key}
                                        checked={!!answers['question_5']?.[key]}
                                        onCheckedChange={(checked) => handleCheckbox('question_5', key, !!checked)}
                                    />
                                    <Label htmlFor={key}>{label}</Label>
                                </div>
                            ))}
                        </div>
                        <div className="mt-4">
                            <div className="grid w-full gap-3">
                                <Label htmlFor="question_5_text">
                                    Wenn eine Abteilung nicht in der Liste enthalten ist, füllen Sie bitte die nachstehende Zeile aus:
                                </Label>
                                <Textarea
                                    id="question_5_text"
                                    value={answers['question_5']?.custom_category || ''}
                                    onChange={(e) => handleTextarea('question_5', e)}
                                    placeholder="Geben Sie hier Ihre Nachricht ein."
                                />
                            </div>
                        </div>
                    </h4>
                </div>
                {/* Question 6 */}
                <div className="mt-4">
                    <h4 className="scroll-m-20 text-xl font-semibold tracking-tight">
                        6. Wer sind die jeweiligen Ansprechpartner der unter Ziffer 5. genannten Abteilungen?
                        <Textarea
                            className="mt-2"
                            id="question_6_text"
                            value={answers['question_6']?.custom_category || ''}
                            onChange={(e) => handleTextarea('question_6', e)}
                            placeholder="Geben Sie hier Ihre Nachricht ein."
                        />
                    </h4>
                </div>
                {/* Question 7 */}
                <div className="mt-4">
                    <h4 className="scroll-m-20 text-xl font-semibold tracking-tight">
                        7. Welche Datenverarbeitungssysteme (z.B. Softwareprogramme, externe Server) werden für die Datenverarbeitung eingesetzt?
                        <div className="mt-2 flex flex-col gap-3">
                            {[
                                ['elo', 'ELO'],
                                ['xero', 'XERO'],
                                ['rocket', 'Rocket'],
                                ['onextwo', 'onextwo'],
                                ['zendesk', 'Zendesk'],
                                ['Insic', 'Insic'],
                                ['asana', 'Asana'],
                                ['reteach', 'reteach'],
                                ['akarion', 'Akarion'],
                                ['compy_radar', 'Comply Radar'],
                                ['slack', 'Slack'],
                                ['trm', 'Time Reporting System'],
                                ['datev', 'Datev'],
                                ['franchise_web', 'Franchise Web'],
                                ['outlook', 'Outlook'],
                                ['skype', 'Skype'],
                                ['whatsapp', 'WhatsApp'],
                                ['sodexo', 'Sodexo'],
                                ['teams', 'Microsoft Teams'],
                                ['regaweb', 'ReGaweb'],
                            ].map(([key, label]) => (
                                <div className="flex items-center gap-3" key={key}>
                                    <Checkbox
                                        id={key}
                                        checked={!!answers['question_7']?.[key]}
                                        onCheckedChange={(checked) => handleCheckbox('question_7', key, !!checked)}
                                    />
                                    <Label htmlFor={key}>{label}</Label>
                                </div>
                            ))}
                        </div>
                        <div className="mt-4">
                            <div className="grid w-full gap-3">
                                <Label htmlFor="question_7_text">
                                    Wenn die von Ihrer Abteilung verwendeten Datenverarbeitungssysteme nicht in der Liste enthalten sind, füllen Sie
                                    bitte die nachstehende Zeile aus:
                                </Label>
                                <Textarea
                                    id="question_7_text"
                                    value={answers['question_7']?.custom_category || ''}
                                    onChange={(e) => handleTextarea('question_7', e)}
                                    placeholder="Geben Sie hier Ihre Nachricht ein."
                                />
                            </div>
                        </div>
                    </h4>
                </div>
                {/* Question 8 */}
                <div className="mt-4">
                    <h4 className="scroll-m-20 text-xl font-semibold tracking-tight">
                        8. Wer außerhalb der IBA Entertainment Ltd. hat auf diese personenbezogenen Daten Zugriff bzw. an wen werden sie übermittelt
                        (auch Konzerngesellschaften)?
                        <div className="mt-2 flex flex-col gap-3">
                            {[
                                ['bet_de', 'Bet 3000 Deutschland Management GmbH'],
                                ['bet_gmbh', 'Bet 3000 GmbH'],
                                ['royal_net', 'Royal Net GmbH'],
                                ['bet_bavaria', 'Bet 3000 Bavaria GmbH'],
                                ['springer', 'Springer GmbH'],
                                ['bet_ent', 'Bet 3000 Entertainment GmbH'],
                                ['oddico', 'Oddico GmbH'],
                            ].map(([key, label]) => (
                                <div className="flex items-center gap-3" key={key}>
                                    <Checkbox
                                        id={key}
                                        checked={!!answers['question_8']?.[key]}
                                        onCheckedChange={(checked) => handleCheckbox('question_8', key, !!checked)}
                                    />
                                    <Label htmlFor={key}>{label}</Label>
                                </div>
                            ))}
                        </div>
                        <div className="mt-4">
                            <div className="grid w-full gap-3">
                                <Label htmlFor="question_8_text">
                                    Wenn die erforderlichen Datenempfänger nicht in der Liste enthalten sind, füllen Sie bitte die nachstehende Zeile
                                    aus:
                                </Label>
                                <Textarea
                                    id="question_8_text"
                                    value={answers['question_7']?.custom_category || ''}
                                    onChange={(e) => handleTextarea('question_8', e)}
                                    placeholder="Geben Sie hier Ihre Nachricht ein."
                                />
                            </div>
                        </div>
                    </h4>
                </div>
                {/* Question 9 */}
                <div className="mt-4">
                    <h4 className="scroll-m-20 text-xl font-semibold tracking-tight">
                        9. Wurden mit den unter Ziffer 8. genannten Personen oder Unternehmen Auftragsdatenverarbeitungsverträge oder sonstige
                        Vereinbarungen abgeschlossen?
                        <Textarea
                            className="mt-2"
                            id="question_9_text"
                            value={answers['question_9']?.custom_category || ''}
                            onChange={(e) => handleTextarea('question_9', e)}
                            placeholder="Geben Sie hier Ihre Nachricht ein."
                        />
                    </h4>
                </div>
                {/* Question 10 */}
                <div className="mt-4">
                    <h4 className="scroll-m-20 text-xl font-semibold tracking-tight">
                        10. Wie lange werden die personenbezogenen Daten aufbewahrt bzw. wann werden sie jeweils gelöscht?
                        <Textarea
                            className="mt-2"
                            id="question_10_text"
                            value={answers['question_10']?.custom_category || ''}
                            onChange={(e) => handleTextarea('question_10', e)}
                            placeholder="Geben Sie hier Ihre Nachricht ein."
                        />
                    </h4>
                </div>
                <div className="mt-4 flex justify-end">
                    <Button type="submit" tabIndex={80}>
                        Save
                    </Button>
                </div>
            </form>
        </Layout>
    );
}
