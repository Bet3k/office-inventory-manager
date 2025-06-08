import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import DisableTwoFactorAuth from '@/pages/settings/partials/disable-two-factor-auth';
import EnableTwoFactorAuth from '@/pages/settings/partials/enable-two-factor-auth';
import QrCode from '@/pages/settings/partials/qr-code';
import RecoveryCodes from '@/pages/settings/partials/recovery-codes';
import { SharedData } from '@/types';
import { usePage } from '@inertiajs/react';

function TwoFactorIndex() {
    const pageProps = usePage<SharedData>().props;
    const auth = pageProps.auth;
    const recentlyConfirmedPassword = pageProps.recentlyConfirmedPassword as boolean;
    const twoFactorEnabled: boolean = pageProps.twoFactorEnabled as boolean;
    const setupCode: string = usePage().props.setupCode as string;
    return (
        <div className="flex w-full items-center justify-center">
            <Card className="w-full">
                <form className="w-full space-y-6">
                    <CardHeader>
                        <CardTitle>Two-Factor Authentication</CardTitle>
                        <CardDescription>Two-Factor Authentication for extra security.</CardDescription>
                    </CardHeader>
                    <CardContent className="flex justify-center">
                        <div className="grid w-full grid-cols-1 gap-4 md:w-1/2">
                            {twoFactorEnabled ? (
                                <div className="flex w-full flex-col items-center justify-center">
                                    <QrCode twoFactorEnabled={twoFactorEnabled} setupCode={setupCode} />

                                    {auth.user.two_factor_confirmed_at && <RecoveryCodes downloadedCode={auth.user.downloaded_codes} />}
                                    <div className="flex w-1/2 flex-col items-center justify-center gap-2 md:flex-row md:gap-0">
                                        <DisableTwoFactorAuth recentlyConfirmedPassword={recentlyConfirmedPassword} />
                                    </div>
                                </div>
                            ) : (
                                <EnableTwoFactorAuth recentlyConfirmedPassword={recentlyConfirmedPassword} />
                            )}
                        </div>
                    </CardContent>
                </form>
            </Card>
        </div>
    );
}

export default TwoFactorIndex;
