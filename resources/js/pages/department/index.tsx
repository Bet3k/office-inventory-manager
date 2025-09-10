import React from 'react';
import type { BreadcrumbItem } from '@/types';
import Layout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';
import DepartmentList from '@/pages/department/department-list';

function Index() {
    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Departments',
            href: route('department.index'),
        },
    ];
    return (
        <Layout breadcrumbs={breadcrumbs}>
            <Head title="Department" />
            <DepartmentList />
        </Layout>
    );
}

export default Index;
