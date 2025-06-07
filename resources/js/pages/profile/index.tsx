import Layout from '@/layouts/app-layout';
import DeleteProfile from '@/pages/profile/delete-profile';
import ProfileData from '@/pages/profile/profile-data';
import type { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

export default function index() {
    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Dashboard',
            href: '/dashboard',
        },
        {
            title: 'Profile',
            href: route('profile.show'),
        },
    ];

    return (
        <Layout breadcrumbs={breadcrumbs}>
            <Head title="Profile" />
            <ProfileData />

            <div className="flex w-full items-center justify-center p-4">
                <DeleteProfile />
            </div>
        </Layout>
    );
}
