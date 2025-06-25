import Layout from '@/layouts/app-layout';
import SoftwareList from '@/pages/software/software-list';
import type { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

export default function Index() {
    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Devices',
            href: route('device.index'),
        },
    ];
    return (
        <Layout breadcrumbs={breadcrumbs}>
            <Head title="Software" />

            <SoftwareList />
        </Layout>
    );
}
