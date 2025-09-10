import React, { FormEventHandler, useState } from 'react';
import { useForm } from '@inertiajs/react';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import { Pen } from 'lucide-react';
import InputWithError from '@/components/input-with-error';
import LoadingButton from '@/components/loading-button';
import { DepartmentInterface } from '@/types/department';

type DepartmentForm = {
    department: string;
};
function CreateUpdateDepartment({department}: {department?: DepartmentInterface}) {
    const [open, setOpen] = useState(false);
    const { data, setData, post, put, processing, reset, clearErrors } = useForm<Required<DepartmentForm>>({
        department: department?.department || '',
    });

    const handelSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        if (department) {
            handelUpdate();
        } else {
            handelCreate();
        }
    };

    const handelCreate = () => {
        post(route('department.store'), {
            onSuccess: () => {
                reset();
                closeModal();
            },
        });
    };

    const handelUpdate = () => {
        put(route('department.update', department?.id), {
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
                {department ? (
                    <span className="cursor-pointer text-sky-400 hover:text-sky-500 hover:underline">Edit</span>
                ) : (
                    <Button>
                        Add <Pen className="ml-2 h-4 w-4" />
                    </Button>
                )}
            </DialogTrigger>
            <DialogContent className="sm:max-w-[425px]">
                <form onSubmit={handelSubmit}>
                    <DialogHeader>
                        <DialogTitle>{department ? 'Update' : 'Add'} Department</DialogTitle>
                        <DialogDescription>Enter Department and submit when done.</DialogDescription>
                    </DialogHeader>
                    <div className="mb-2 grid gap-4">
                        <div className="grid gap-3">
                            <InputWithError
                                label="Department Name"
                                name="department"
                                type="text"
                                autoFocus
                                tabIndex={1}
                                autoComplete="department"
                                value={data.department}
                                onChange={(e) => setData('department', e.target.value)}
                                placeholder="Nutzungshistorie"
                            />
                        </div>
                    </div>
                    <DialogFooter>
                        <DialogClose asChild>
                            <Button type="button" variant="outline" onClick={closeModal}>
                                Cancel
                            </Button>
                        </DialogClose>
                        <LoadingButton processing={processing} text='Save' tabIndex={3} fullWidth={false} />
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    );
}

export default CreateUpdateDepartment;
