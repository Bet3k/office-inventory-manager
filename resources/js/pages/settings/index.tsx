import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import Layout from '@/layouts/app-layout';
import ConnectedAccounts from '@/pages/settings/partials/connected-accounts';
import PasswordManager from '@/pages/settings/partials/password-manager';
import SessionList from '@/pages/settings/partials/session-list';
import TwoFactorIndex from '@/pages/settings/partials/two-factor-index';
import { BreadcrumbItem } from '@/types';
import { Session } from '@/types/sessions';
import { Head, usePage } from '@inertiajs/react';
import { Lock, Monitor, ShieldCheck } from 'lucide-react';

export default function Index() {
    const pageProps = usePage().props;
    const sessions = pageProps.sessions as Session[];
    const linkAuth = pageProps.linkAuth as boolean;

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Dashboard',
            href: '/dashboard',
        },
        {
            title: 'Settings',
            href: route('profile.show'),
        },
    ];

    return (
        <Layout breadcrumbs={breadcrumbs}>
            <Head title="Settings" />

            <div className="flex w-full items-center justify-center p-4">
                <Tabs defaultValue={linkAuth ? 'connectedAccounts' : 'password'} className="w-full md:w-1/2">
                    <TabsList className="grid grid-cols-4">
                        <TabsTrigger value="password">
                            <Lock className="h-4 w-4 md:hidden" />
                            <span className="hidden md:flex md:gap-2">
                                <Lock /> Password
                            </span>
                        </TabsTrigger>
                        <TabsTrigger value="2fa">
                            <ShieldCheck className="h-4 w-4 md:hidden" />
                            <span className="hidden md:flex md:gap-2">
                                <ShieldCheck /> Two-Factor Auth
                            </span>
                        </TabsTrigger>
                        {/*<TabsTrigger value="connectedAccounts">
                            <Link className="h-4 w-4 md:hidden" />
                            <span className="hidden md:flex md:gap-2">
                                <Link /> Connected Accounts
                            </span>
                        </TabsTrigger>*/}
                        <TabsTrigger value="sessions">
                            <Monitor className="h-4 w-4 md:hidden" />
                            <span className="hidden md:flex md:gap-2">
                                <Monitor /> Sessions
                            </span>
                        </TabsTrigger>
                    </TabsList>

                    <TabsContent value="password">
                        <PasswordManager />
                    </TabsContent>
                    <TabsContent value="2fa">
                        <TwoFactorIndex />
                    </TabsContent>
                    <TabsContent value="connectedAccounts">
                        <ConnectedAccounts />
                    </TabsContent>
                    <TabsContent value="sessions">
                        <SessionList sessions={sessions} />
                    </TabsContent>
                </Tabs>
            </div>
        </Layout>
    );
}
