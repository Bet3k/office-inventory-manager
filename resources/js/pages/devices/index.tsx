import Layout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';
import type { BreadcrumbItem } from '@/types';

export default function Index() {
    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Devices',
            href: route('device.index'),
        },
    ];
    return (
        <Layout breadcrumbs={breadcrumbs}>
            <Head title="Devices" />
        </Layout>
    );
}
