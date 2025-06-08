import Layout from '@/layouts/app-layout';
import PasswordManager from '@/pages/settings/partials/password-manager';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

export default function Index() {
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

            <PasswordManager />
        </Layout>
    );
}
