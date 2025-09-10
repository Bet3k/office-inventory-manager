import React from 'react';
import { router, useForm, usePage } from '@inertiajs/react';
import {
    PaginatedDepartmentInterface, DepartmentInterface,
    DepartmentInterfaceFilters
} from '@/types/department';
import { Permissions } from '@/types/common';
import { Card, CardAction, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { ArrowUpDown, X } from 'lucide-react';
import { Input } from '@/components/ui/input';
import PaginatedFooter from '@/components/paginated-footer';
import CreateUpdateDepartment from '@/pages/department/create-update-department';
import DeleteDepartment from '@/pages/department/delete-department';

function DepartmentList() {
    const pageProps = usePage().props;
    const departments = pageProps.departments as PaginatedDepartmentInterface;
    const permissions = pageProps.permissions as Permissions;
    const filters: DepartmentInterfaceFilters = pageProps.filters as DepartmentInterfaceFilters;
    const { data, setData } = useForm({
        search: filters?.search || '',
        per_page: filters?.per_page || '15',
        sort_order: filters?.sort_order || '',
        sort_field: filters?.sort_field || '',
    });

    const filterDepartment = (overrides: Partial<typeof data>) => {
        router.get(
            route('department.index'),
            {
                search: data.search,
                per_page: data.per_page,
                page: 1,
                ...overrides,
            },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
            },
        );
    };

    const handleSort = (field: 'department') => {
        let order: 'asc' | 'desc' | '' = 'asc';

        if (data.sort_field === field) {
            if (data.sort_order === 'asc') order = 'desc';
            else if (data.sort_order === 'desc') order = '';
            else order = 'asc';
        }

        setData({
            ...data,
            sort_field: order ? field : '',
            sort_order: order,
        });

        filterDepartment({
            sort_field: order ? field : '',
            sort_order: order,
        });
    };

    return (
        <Card className="px-4 py-9">
            <CardHeader className="flex w-full flex-col">
                <div className="mb-3 flex w-full justify-between">
                    <div>
                        <CardTitle>Department</CardTitle>
                        <CardDescription>List of all Department</CardDescription>
                    </div>
                    <CardAction>{permissions.create && <CreateUpdateDepartment />}</CardAction>
                </div>

                <div className="flex w-full flex-col justify-end md:flex-row">
                    <Select
                        value={data.per_page}
                        onValueChange={(value) => {
                            setData('per_page', value);
                            filterDepartment({ per_page: value });
                        }}
                    >
                        <SelectTrigger className="mt-1 max-w-20">
                            <SelectValue placeholder="Select Page Length" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Pages</SelectLabel>
                                <SelectItem value="15">15</SelectItem>
                                <SelectItem value="25">25</SelectItem>
                                <SelectItem value="50">50</SelectItem>
                                <SelectItem value="100">100</SelectItem>
                                <SelectItem value="150">150</SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
            </CardHeader>
            <CardContent>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead onClick={() => handleSort('department')} className="cursor-pointer">
                                <div className="flex items-center gap-1">
                                    Department
                                    <ArrowUpDown size={15} className={data.sort_field === 'department' ? 'text-black' : 'text-gray-500'} />
                                </div>
                            </TableHead>
                        </TableRow>
                        <TableRow>
                            <TableHead>
                                <div className="relative my-2 md:w-1/4">
                                    <Input
                                        type="text"
                                        id="search"
                                        name="search"
                                        value={data.search}
                                        onChange={(e) => {
                                            const value = e.target.value;
                                            setData('search', value);
                                            filterDepartment({ search: value });
                                        }}
                                        placeholder="Search Department"
                                        className="pr-10"
                                    />
                                    {data.search && (
                                        <button
                                            type="button"
                                            onClick={() => {
                                                setData('search', '');
                                                filterDepartment({ search: '' });
                                            }}
                                            className="absolute top-1/2 right-2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                        >
                                            <X size={16} />
                                        </button>
                                    )}
                                </div>
                            </TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        {departments.data.map((department: DepartmentInterface) => (
                            <TableRow key={department.id} className="even:bg-muted">
                                <TableCell className="font-medium">{department.department}</TableCell>

                                <TableCell className="flex justify-end gap-2">
                                    {permissions.update && <CreateUpdateDepartment department={department} />}
                                    {permissions.delete && <DeleteDepartment department={department} />}
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </CardContent>
            <CardFooter>
                <PaginatedFooter paginator={departments} />
            </CardFooter>
        </Card>
    );
}

export default DepartmentList;
