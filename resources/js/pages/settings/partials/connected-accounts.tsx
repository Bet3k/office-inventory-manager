import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { ConnectedAccount } from '@/types';
import { router, usePage } from '@inertiajs/react';
import { FaGoogle } from 'react-icons/fa';

function ConnectedAccounts() {
    const connectedAccounts = usePage().props.connectedAccounts as ConnectedAccount[];

    const handleDisconnect = (id: string) => {
        router.delete(route('connected-accounts.destroy', { id }));
    };

    const services = [
        {
            title: 'Google Connection',
            url: route('settings.google.redirect'),
            icon: <FaGoogle size={25} />,
            service: 'google',
        },
    ];

    return (
        <div className="flex w-full items-center justify-center">
            <Card className="w-full">
                <form className="w-full space-y-6">
                    <CardHeader>
                        <CardTitle>Connected Accounts</CardTitle>
                        <CardDescription>Accounts allowed to login with</CardDescription>
                    </CardHeader>
                    <CardContent className="flex justify-center">
                        <div className="grid w-full grid-cols-1 gap-4 md:w-1/2">
                            {services.map((connection) => {
                                const matched = connectedAccounts.find((acc) => acc.service === connection.service);

                                return (
                                    <div key={connection.service} className="flex items-center justify-between rounded border p-4">
                                        <div className="flex items-center gap-2">
                                            {connection.icon}
                                            <span>{connection.title}</span>
                                        </div>

                                        {matched ? (
                                            <Button variant="destructive" onClick={() => handleDisconnect(matched.id)} type="button">
                                                Disconnect
                                            </Button>
                                        ) : (
                                            <Button variant="outline" onClick={() => (window.location.href = connection.url)} type="button">
                                                Connect
                                            </Button>
                                        )}
                                    </div>
                                );
                            })}
                        </div>
                    </CardContent>
                </form>
            </Card>
        </div>
    );
}

export default ConnectedAccounts;
