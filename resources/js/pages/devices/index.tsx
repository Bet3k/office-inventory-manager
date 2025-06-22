import Layout from '@/layouts/app-layout';
import AllDevicesList from '@/pages/devices/partials/all-devices-list';
import CreateUpdateDevice from '@/pages/devices/partials/create-update-device';
import type { BreadcrumbItem } from '@/types';
import { PaginatedDeviceInterface } from '@/types/device';
import { Head, usePage } from '@inertiajs/react';

export default function Index() {
    const pageProps = usePage().props;
    const devices = pageProps.devices as PaginatedDeviceInterface;
    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Devices',
            href: route('device.index'),
        },
    ];
    return (
        <Layout breadcrumbs={breadcrumbs}>
            <Head title="Devices" />

            <div className="mb-2 flex justify-end">
                <CreateUpdateDevice />
            </div>

            <AllDevicesList devices={devices} />
        </Layout>
    );
}
