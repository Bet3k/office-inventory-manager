import PaginatedFooter from '@/components/paginated-footer';
import { CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import ReturnDevice from '@/pages/member-of-staff/partials/return-device';
import { Permissions } from '@/types/common';
import { DeviceMappingInterface, DeviceMappingInterfaceFilters, PaginatedDeviceMappingInterface } from '@/types/device-mapping';
import { MembersOfStaffInterface } from '@/types/members-of-staff';
import { router, useForm, usePage } from '@inertiajs/react';
import { ArrowUpDown, X } from 'lucide-react';

function AssignedDevices({ devices, memberOfStaff }: { devices: PaginatedDeviceMappingInterface; memberOfStaff: MembersOfStaffInterface }) {
    const pageProps = usePage().props;
    const deviceAssignmentPermissions = pageProps.deviceAssignmentPermissions as Permissions;
    const filters: DeviceMappingInterfaceFilters = pageProps.filters as DeviceMappingInterfaceFilters;
    const { data, setData } = useForm({
        search: filters?.search || '',
        per_page: filters?.per_page || '15',
        sort_order: filters?.sort_order || '',
        sort_field: filters?.sort_field || '',
    });

    const filterMembersOfStaff = (overrides: Partial<typeof data>) => {
        router.get(
            route('member-of-staff.show', memberOfStaff.id),
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

    const handleSort = (field: 'brand' | 'type' | 'status' | 'service_status' | 'serial_number') => {
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

        filterMembersOfStaff({
            sort_field: order ? field : '',
            sort_order: order,
        });
    };
    return (
        <div className="px-4 py-9">
            <CardHeader className="flex w-full flex-col">
                <div className="mb-3 flex w-full justify-between">
                    <div>
                        <CardTitle>Devices</CardTitle>
                        <CardDescription>List of all assigned Devices to current member of staff</CardDescription>
                    </div>
                </div>

                <div className="flex w-full flex-col justify-between md:flex-row">
                    <div className="relative my-2 md:w-1/4">
                        <Input
                            type="text"
                            id="search"
                            name="search"
                            value={data.search}
                            onChange={(e) => {
                                const value = e.target.value;
                                setData('search', value);
                                filterMembersOfStaff({ search: value });
                            }}
                            placeholder="Search Device"
                            className="pr-10"
                        />
                        {data.search && (
                            <button
                                type="button"
                                onClick={() => {
                                    setData('search', '');
                                    filterMembersOfStaff({ search: '' });
                                }}
                                className="absolute top-1/2 right-2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                            >
                                <X size={16} />
                            </button>
                        )}
                    </div>
                    <Select
                        value={data.per_page}
                        onValueChange={(value) => {
                            setData('per_page', value);
                            filterMembersOfStaff({ per_page: value });
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
                            <TableHead onClick={() => handleSort('brand')} className="cursor-pointer">
                                <div className="flex items-center gap-1">
                                    Brand
                                    <ArrowUpDown size={15} className={data.sort_field === 'brand' ? 'text-black' : 'text-gray-500'} />
                                </div>
                            </TableHead>

                            <TableHead onClick={() => handleSort('type')} className="cursor-pointer">
                                <div className="flex items-center gap-1">
                                    Type
                                    <ArrowUpDown size={15} className={data.sort_field === 'type' ? 'text-black' : 'text-gray-500'} />
                                </div>
                            </TableHead>

                            <TableHead onClick={() => handleSort('serial_number')} className="cursor-pointer">
                                <div className="flex items-center gap-1">
                                    Serial Number
                                    <ArrowUpDown size={15} className={data.sort_field === 'serial_number' ? 'text-black' : 'text-gray-500'} />
                                </div>
                            </TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        {devices.data.map((device: DeviceMappingInterface) => (
                            <TableRow key={device.id} className="even:bg-muted">
                                <TableCell className="font-medium">{device.brand}</TableCell>
                                <TableCell>{device.type}</TableCell>
                                <TableCell>{device.serial_number}</TableCell>
                                <TableCell className="flex justify-end gap-2">
                                    {deviceAssignmentPermissions.delete && <ReturnDevice device={device} />}
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </CardContent>
            <CardFooter>
                <PaginatedFooter paginator={devices} />
            </CardFooter>
        </div>
    );
}

export default AssignedDevices;
