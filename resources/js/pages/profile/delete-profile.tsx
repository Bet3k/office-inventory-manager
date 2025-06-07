import { useForm, usePage } from '@inertiajs/react';
import { FormEventHandler, useRef } from 'react';

import { Button } from '@/components/ui/button';

import HeadingSmall from '@/components/heading-small';

import { DialogDrawer } from '@/components/dialog-drawer';
import LoadingButton from '@/components/loading-button';
import PasswordInputWithError from '@/components/password-input-with-error';
import { Card, CardContent } from '@/components/ui/card';
import { SharedData } from '@/types';

export default function DeleteProfile() {
    const { auth } = usePage<SharedData>().props;
    const passwordInput = useRef<HTMLInputElement>(null);
    const {
        data,
        setData,
        delete: destroy,
        processing,
        reset,
        clearErrors,
    } = useForm<
        Required<{
            password: string;
        }>
    >({ password: '' });

    const deleteUser: FormEventHandler = (e) => {
        e.preventDefault();

        destroy(route('profile.destroy', auth.user.profile.id), {
            preserveScroll: true,
            onError: () => {
                reset();
                passwordInput.current?.focus();
            },
        });
    };

    return (
        <Card className="md:w-1/2">
            <CardContent>
                <HeadingSmall title="Delete account" description="Delete your account and all of its resources" />
                <div className="mt-2 space-y-4 rounded-lg border border-red-100 bg-red-50 p-4 dark:border-red-200/10 dark:bg-red-700/10">
                    <div className="relative space-y-0.5 text-red-600 dark:text-red-100">
                        <p className="font-medium">Warning</p>
                        <p className="mb-4 text-sm">Please proceed with caution, this cannot be undone.</p>
                    </div>
                    <div className="flex justify-end">
                        <DialogDrawer
                            title="Delete account"
                            description="Once deleted, all your data will be permanently lost."
                            triggerText="Delete account"
                            btnType="destructive"
                        >
                            {({ close }) => (
                                <form onSubmit={deleteUser} className="space-y-6">
                                    <div className="grid gap-2">
                                        <PasswordInputWithError
                                            label="Password"
                                            name="password"
                                            forgotPassword={false}
                                            required
                                            tabIndex={2}
                                            autoComplete="password"
                                            value={data.password}
                                            onChange={(e) => setData('password', e.target.value)}
                                            placeholder="••••••••"
                                        />
                                    </div>

                                    <div className="flex justify-end gap-2 pt-4">
                                        <Button
                                            type="button"
                                            variant="secondary"
                                            onClick={() => {
                                                close();
                                                clearErrors();
                                                reset();
                                            }}
                                        >
                                            Cancel
                                        </Button>
                                        <LoadingButton processing={processing} text="Delete Account" destructive />
                                    </div>
                                </form>
                            )}
                        </DialogDrawer>
                    </div>
                </div>
            </CardContent>
        </Card>
    );
}
