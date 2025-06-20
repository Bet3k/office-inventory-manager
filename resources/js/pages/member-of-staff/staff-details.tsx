import { Card, CardAction, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import Layout from '@/layouts/app-layout';
import CreateUpdateStaff from '@/pages/member-of-staff/partials/create-update-staff';
import type { BreadcrumbItem } from '@/types';
import { MembersOfStaffInterface } from '@/types/members-of-staff';
import { Head } from '@inertiajs/react';

export default function StaffDetails({ memberOfStaff }: { memberOfStaff: MembersOfStaffInterface }) {
    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Members of Staff',
            href: route('member-of-staff.index'),
        },
        {
            title: 'Staff Details',
            href: route('member-of-staff.show', memberOfStaff.id),
        },
    ];
    return (
        <Layout breadcrumbs={breadcrumbs}>
            <Head title="Staff Details" />
            <Card className="px-4 py-9">
                <CardHeader>
                    <CardTitle>
                        {memberOfStaff.first_name} {memberOfStaff.last_name}
                    </CardTitle>
                    <CardAction>
                        <CreateUpdateStaff memberOfStaff={memberOfStaff} />
                    </CardAction>
                </CardHeader>
                <CardContent></CardContent>
            </Card>
        </Layout>
    );
}
