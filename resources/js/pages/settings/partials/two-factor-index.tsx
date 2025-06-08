import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import EnableTwoFactorAuth from '@/pages/settings/partials/enable-two-factor-auth';
import { SharedData } from '@/types';
import { usePage } from '@inertiajs/react';

function TwoFactorIndex() {
    const pageProps = usePage<SharedData>().props;
    const recentlyConfirmedPassword = pageProps.recentlyConfirmedPassword as boolean;
    const twoFactorEnabled: boolean = pageProps.twoFactorEnabled as boolean;
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
                            {twoFactorEnabled ? <h1>deactivate</h1> : <EnableTwoFactorAuth recentlyConfirmedPassword={recentlyConfirmedPassword} />}
                        </div>
                    </CardContent>
                </form>
            </Card>
        </div>
    );
}

export default TwoFactorIndex;
