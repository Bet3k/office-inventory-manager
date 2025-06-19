import Layout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

export default function index() {
    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Members of Staff',
            href: '/dashboard',
        },
    ];
    return (
        <Layout breadcrumbs={breadcrumbs}>
            <Head title="Members of Staff" />
        </Layout>
    );
}
