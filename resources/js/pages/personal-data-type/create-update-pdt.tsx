import React, { FormEventHandler, useState } from 'react';
import { useForm } from '@inertiajs/react';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import { Pen } from 'lucide-react';
import InputWithError from '@/components/input-with-error';
import LoadingButton from '@/components/loading-button';
import { PersonalDataTypeInterface } from '@/types/personal-data-types';

type PersonalDataProcessedForm = {
    data_type: string;
};
function CreateUpdatePdt({personalDataType}: {personalDataType?: PersonalDataTypeInterface}) {
    const [open, setOpen] = useState(false);
    const { data, setData, post, put, processing, reset, clearErrors } = useForm<Required<PersonalDataProcessedForm>>({
        data_type: personalDataType?.data_type || '',
    });

    const handelSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        if (personalDataType) {
            handelUpdate();
        } else {
            handelCreate();
        }
    };

    const handelCreate = () => {
        post(route('personal-data-type.store'), {
            onSuccess: () => {
                reset();
                closeModal();
            },
        });
    };

    const handelUpdate = () => {
        put(route('personal-data-type.update', personalDataType?.id), {
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
                {personalDataType ? (
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
                        <DialogTitle>{personalDataType ? 'Update' : 'Add'} Personal Data Type</DialogTitle>
                        <DialogDescription>Enter Personal Data Type and submit when done.</DialogDescription>
                    </DialogHeader>
                    <div className="mb-2 grid gap-4">
                        <div className="grid gap-3">
                            <InputWithError
                                label="Name"
                                name="data_type"
                                type="text"
                                autoFocus
                                tabIndex={1}
                                autoComplete="data_type"
                                value={data.data_type}
                                onChange={(e) => setData('data_type', e.target.value)}
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

export default CreateUpdatePdt;
