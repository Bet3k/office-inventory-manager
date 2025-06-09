import { Button } from '@/components/ui/button';
import { router } from '@inertiajs/react';
import axios from 'axios';
import { useEffect, useState } from 'react';

function RecoveryCodes({ downloadedCode }: { downloadedCode: boolean }) {
    const [recoveryCodes, setRecoveryCodes] = useState<string[] | null>(null);

    /**
     * Uses Axios to make a GET request to the server endpoint '/user/two-factor-recovery-codes'
     * because Inertia does not handle JSON responses.
     * */

    const handleGetTwoFactorRecoveryCodes = () => {
        axios.get('/user/two-factor-recovery-codes').then((response) => {
            setRecoveryCodes(response.data);
        });
    };

    const handleGenerateTwoFactorRecoveryCodes = () => {
        router.post(
            '/user/two-factor-recovery-codes',
            {},
            {
                onSuccess: () => {
                    router.put(route('two-factor-authentication-recovery-codes.update'), {
                        downloaded_codes: false,
                    });
                    handleGetTwoFactorRecoveryCodes();
                },
            },
        );
    };

    useEffect(() => {
        handleGetTwoFactorRecoveryCodes();
    }, []);

    const handleDownloadCodes = () => {
        const blob = new Blob([recoveryCodes!.join('\n')], {
            type: 'text/plain',
        });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'recoveryCodes.txt';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(link.href);

        router.put(route('two-factor-authentication-recovery-codes.update'), {
            downloaded_codes: true,
        });
    };

    return (
        <div className="mb-4 flex w-full flex-col items-center justify-center">
            {!downloadedCode && (
                <div className="my-2 flex items-center justify-center">
                    <ul>
                        {recoveryCodes &&
                            recoveryCodes.map((code: string, index: number) => (
                                <li key={index} className="mb-2 font-bold text-gray-900">
                                    {code}
                                </li>
                            ))}
                    </ul>
                </div>
            )}

            <div className="flex items-center justify-center gap-2">
                {!downloadedCode && (
                    <Button type="button" onClick={handleDownloadCodes}>
                        Download Codes
                    </Button>
                )}
                <Button type="button" variant="outline" onClick={handleGenerateTwoFactorRecoveryCodes}>
                    Generate New Codes
                </Button>
            </div>
        </div>
    );
}

export default RecoveryCodes;
