import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import ConfirmTwoFactor from '@/pages/settings/partials/confirm-two-factor';
import DisableTwoFactorAuth from '@/pages/settings/partials/disable-two-factor-auth';
import EnableTwoFactorAuth from '@/pages/settings/partials/enable-two-factor-auth';
import QrCode from '@/pages/settings/partials/qr-code';
import RecoveryCodes from '@/pages/settings/partials/recovery-codes';
import { SharedData } from '@/types';
import { usePage } from '@inertiajs/react';

function TwoFactorIndex() {
    const { auth } = usePage<SharedData>().props;
    const pageProps = usePage().props;
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
                        <div className="grid w-full grid-cols-1 gap-4 md:w-3/4">
                            {twoFactorEnabled ? (
                                <div className="flex w-full flex-col items-center justify-center">
                                    <QrCode twoFactorEnabled={twoFactorEnabled} setupCode={setupCode} />

                                    {auth.user.two_factor_confirmed_at && <RecoveryCodes downloadedCode={auth.user.downloaded_codes} />}

                                    <div className="flex w-full flex-col items-center justify-center gap-2 md:flex-row">
                                        <DisableTwoFactorAuth recentlyConfirmedPassword={recentlyConfirmedPassword} />
                                        {!auth.user.two_factor_confirmed_at && <ConfirmTwoFactor />}
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
