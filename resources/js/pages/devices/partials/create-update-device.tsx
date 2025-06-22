import InputWithError from '@/components/input-with-error';
import LoadingButton from '@/components/loading-button';
import SelectWithError from '@/components/select-with-error';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { DeviceInterface } from '@/types/device';
import { useForm } from '@inertiajs/react';
import { Pen } from 'lucide-react';
import { FormEventHandler, useState } from 'react';

type StaffForm = {
    brand: string;
    type: string;
    status: string;
    service_status: string;
    serial_number: string;
};

function CreateUpdateDevice({ device }: { device?: DeviceInterface }) {
    const [open, setOpen] = useState(false);
    const { data, setData, post, put, processing, reset, clearErrors } = useForm<Required<StaffForm>>({
        brand: device?.brand || '',
        type: device?.type || '',
        status: device?.status || '',
        service_status: device?.service_status || '',
        serial_number: device?.serial_number || '',
    });

    const handelSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        if (device) {
            handelUpdate();
        } else {
            handelCreate();
        }
    };

    const handelCreate = () => {
        post(route('device.store'), {
            onSuccess: () => {
                reset();
                closeModal();
            },
        });
    };

    const handelUpdate = () => {
        put(route('device.update', device?.id), {
            onSuccess: () => {
                reset();
                closeModal();
            },
        });
    };

    const closeModal = () => {
        clearErrors();
        setOpen(false);
        reset();
    };

    return (
        <Dialog open={open} onOpenChange={setOpen}>
            <DialogTrigger asChild>
                {device ? (
                    <span className="cursor-pointer text-sky-400 hover:text-sky-500 hover:underline">Edit Device</span>
                ) : (
                    <Button>
                        Add Device <Pen className="ml-2 h-4 w-4" />
                    </Button>
                )}
            </DialogTrigger>
            <DialogContent className="sm:max-w-[425px]">
                <form onSubmit={handelSubmit}>
                    <DialogHeader>
                        <DialogTitle>{device ? 'Update' : 'Add'} Device</DialogTitle>
                        <DialogDescription>Enter Device details and submit when done.</DialogDescription>
                    </DialogHeader>
                    <div className="mb-2 grid gap-4">
                        <div className="grid gap-3">
                            <InputWithError
                                label="Brand"
                                name="brand"
                                type="text"
                                autoFocus
                                tabIndex={1}
                                autoComplete="brand"
                                value={data.brand}
                                onChange={(e) => setData('brand', e.target.value)}
                                placeholder="Apple"
                            />
                        </div>
                        <div className="grid gap-3">
                            <InputWithError
                                label="Type"
                                name="type"
                                type="text"
                                tabIndex={2}
                                autoComplete="type"
                                value={data.type}
                                onChange={(e) => setData('type', e.target.value)}
                                placeholder="Notebook"
                            />
                        </div>
                    </div>
                    <div className="mb-2 grid gap-4">
                        <div className="grid gap-3">
                            <SelectWithError
                                label="Status"
                                name="status"
                                value={data.status}
                                onChange={(value) => setData('status', value)}
                                placeholder="Select Status"
                                options={['Functional', 'Non-Functional', 'In-Repair']}
                            />
                        </div>
                        <div className="grid gap-3">
                            <SelectWithError
                                label="Service Status"
                                name="service_status"
                                value={data.service_status}
                                onChange={(value) => setData('service_status', value)}
                                placeholder="Select Service Status"
                                options={['Assigned', 'Available', 'Decommissioned']}
                            />
                        </div>
                    </div>
                    <div className="mb-2 grid gap-4">
                        <div className="grid gap-3">
                            <InputWithError
                                label="Serial Number"
                                name="serial_number"
                                type="text"
                                tabIndex={2}
                                autoComplete="serial_number"
                                value={data.serial_number}
                                onChange={(e) => setData('serial_number', e.target.value)}
                                placeholder="SN-1234-567890"
                            />
                        </div>
                    </div>
                    <DialogFooter>
                        <DialogClose asChild>
                            <Button type="button" variant="outline" onClick={closeModal}>
                                Cancel
                            </Button>
                        </DialogClose>
                        <LoadingButton processing={processing} text={device ? 'Update' : 'Create'} tabIndex={3} fullWidth={false} />
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    );
}

export default CreateUpdateDevice;
