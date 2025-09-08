import Layout from '@/layouts/app-layout'
import { Head } from '@inertiajs/react'
import type { BreadcrumbItem } from '@/types';
import DataTypesList from '@/pages/personal-data-type/data-types-list';

export default function Index() {
    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Personal Data Type',
            href: route('personal-data-type.index'),
        },
    ];
    return (
        <Layout breadcrumbs={breadcrumbs}>
            <Head title="Personal Data Processed" />

            <DataTypesList />
        </Layout>
    );
}
