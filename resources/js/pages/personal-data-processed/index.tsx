import Layout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import DataList from '@/pages/personal-data-processed/data-list';

export default function Index() {
    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Personal Data Processed',
            href: route('device.index'),
        },
    ];
    return (
        <Layout breadcrumbs={breadcrumbs}>
            <Head title="Personal Data Processed" />

            <DataList />
        </Layout>
    );
}
