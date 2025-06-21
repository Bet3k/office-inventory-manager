import Layout from '@/layouts/app-layout';
import MembersOfStaffList from '@/pages/member-of-staff/partials/members-of-staff-list';
import type { BreadcrumbItem } from '@/types';
import { PaginatedMembersOfStaffInterface } from '@/types/members-of-staff';
import { Head, usePage } from '@inertiajs/react';

export default function Index() {
    const pageProps = usePage().props;
    const membersOfStaff = pageProps.membersOfStaff as PaginatedMembersOfStaffInterface;

    console.log(membersOfStaff);

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Members of Staff',
            href: route('member-of-staff.index'),
        },
    ];
    return (
        <Layout breadcrumbs={breadcrumbs}>
            <Head title="Members of Staff" />
            <MembersOfStaffList membersOfStaff={membersOfStaff} />
        </Layout>
    );
}
