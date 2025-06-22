import PaginatedFooter from '@/components/paginated-footer';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import CreateUpdateDevice from '@/pages/devices/partials/create-update-device';
import DeleteDevice from '@/pages/devices/partials/delete-device';
import { DeviceInterface, DeviceInterfaceFilters, PaginatedDeviceInterface } from '@/types/device';
import { router, useForm, usePage } from '@inertiajs/react';
import { clsx } from 'clsx';
import { ArrowUpDown, X } from 'lucide-react';

function AllDevicesList({ devices }: { devices: PaginatedDeviceInterface }) {
    const pageProps = usePage().props;
    const filters: DeviceInterfaceFilters = pageProps.filters as DeviceInterfaceFilters;
    const { data, setData } = useForm({
        search: filters?.search || '',
        per_page: filters?.per_page || '15',
        sort_order: filters?.sort_order || '',
        sort_field: filters?.sort_field || '',
    });

    const filterMembersOfStaff = (overrides: Partial<typeof data>) => {
        router.get(
            route('device.index'),
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
        <Card className="px-4 py-9">
            <CardHeader className="flex w-full flex-col">
                <div className="mb-3 flex w-full justify-between">
                    <div>
                        <CardTitle>Devices</CardTitle>
                        <CardDescription>List of all active Devices</CardDescription>
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
                            <TableHead onClick={() => handleSort('status')} className="cursor-pointer">
                                <div className="flex items-center gap-1">
                                    Status
                                    <ArrowUpDown size={15} className={data.sort_field === 'status' ? 'text-black' : 'text-gray-500'} />
                                </div>
                            </TableHead>

                            <TableHead onClick={() => handleSort('service_status')} className="cursor-pointer">
                                <div className="flex items-center gap-1">
                                    Service Status
                                    <ArrowUpDown size={15} className={data.sort_field === 'service_status' ? 'text-black' : 'text-gray-500'} />
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
                        {devices.data.map((device: DeviceInterface) => (
                            <TableRow key={device.id} className="even:bg-muted">
                                <TableCell className="font-medium">{device.brand}</TableCell>
                                <TableCell>{device.type}</TableCell>
                                <TableCell>
                                    <Badge
                                        className={clsx({
                                            'bg-green-500': device.status === 'Functional',
                                            'bg-red-500': device.status === 'Non-Functional',
                                            'bg-yellow-500': device.status === 'In-Repair',
                                        })}
                                    >
                                        {device.status}
                                    </Badge>
                                </TableCell>
                                <TableCell>
                                    <Badge
                                        className={clsx({
                                            'bg-green-500': device.service_status === 'Available',
                                            'bg-sky-500': device.service_status === 'Assigned',
                                            'bg-red-500': device.service_status === 'Decommissioned',
                                        })}
                                    >
                                        {device.service_status}
                                    </Badge>
                                </TableCell>
                                <TableCell>{device.serial_number}</TableCell>
                                <TableCell className="flex justify-end gap-2">
                                    <CreateUpdateDevice device={device} />
                                    <DeleteDevice device={device} />
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </CardContent>
            <CardFooter>
                <PaginatedFooter paginator={devices} />
            </CardFooter>
        </Card>
    );
}

export default AllDevicesList;
