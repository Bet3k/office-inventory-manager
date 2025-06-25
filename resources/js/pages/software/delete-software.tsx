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
import { SoftwareInterface } from '@/types/software';
import { useForm } from '@inertiajs/react';
import { FormEventHandler, useRef, useState } from 'react';

type DeleteSoftwareForm = {
    password: string;
};

function DeleteSoftware({ software }: { software: SoftwareInterface }) {
    const [open, setOpen] = useState(false);
    const passwordInput = useRef<HTMLInputElement>(null);
    const {
        data,
        setData,
        delete: destroy,
        processing,
        reset,
        clearErrors,
    } = useForm<Required<DeleteSoftwareForm>>({
        password: '',
    });

    const handelSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        destroy(route('software.destroy', software.id), {
            onSuccess: () => {
                reset();
                closeModal();
            },
            onError: () => {
                reset();
                passwordInput.current?.focus();
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
                <span className="cursor-pointer text-red-400 hover:text-red-600 hover:underline">Delete</span>
            </DialogTrigger>
            <DialogContent className="sm:max-w-[425px]">
                <form onSubmit={handelSubmit}>
                    <DialogHeader>
                        <DialogTitle>Delete Software</DialogTitle>
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
                        <LoadingButton destructive={true} processing={processing} text="Delete" tabIndex={2} fullWidth={false} />
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    );
}

export default DeleteSoftware;
