import LoadingButton from '@/components/loading-button';
import PasswordInputWithError from '@/components/password-input-with-error';
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
import { DeviceMappingInterface } from '@/types/device-mapping';
import { useForm } from '@inertiajs/react';
import { FormEventHandler, useState } from 'react';

type DeleteStaffForm = {
    password: string;
};

function ReturnDevice({ device }: { device: DeviceMappingInterface }) {
    const [open, setOpen] = useState(false);
    const {
        data,
        setData,
        delete: destroy,
        processing,
        reset,
        clearErrors,
    } = useForm<Required<DeleteStaffForm>>({
        password: '',
    });

    const handelSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        destroy(route('device-staff-mapping.destroy', device.mapping_id), {
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
                <span className="cursor-pointer text-red-400 hover:text-red-600 hover:underline">Return Device</span>
            </DialogTrigger>
            <DialogContent className="sm:max-w-[425px]">
                <form onSubmit={handelSubmit}>
                    <DialogHeader>
                        <DialogTitle>Return Device to stock</DialogTitle>
                        <DialogDescription>Are you sure? This action cannot be undone. Enter password to confirm</DialogDescription>
                    </DialogHeader>
                    <div className="mt-3 mb-2 grid gap-4">
                        <div className="grid gap-3">
                            <PasswordInputWithError
                                label="Password"
                                forgotPassword={false}
                                name="password"
                                autoFocus
                                tabIndex={1}
                                autoComplete="password"
                                value={data.password}
                                onChange={(e) => setData('password', e.target.value)}
                            />
                        </div>
                    </div>
                    <DialogFooter>
                        <DialogClose asChild>
                            <Button type="button" variant="outline" onClick={closeModal}>
                                Cancel
                            </Button>
                        </DialogClose>
                        <LoadingButton destructive={true} processing={processing} text="Return" tabIndex={2} fullWidth={false} />
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    );
}

export default ReturnDevice;
