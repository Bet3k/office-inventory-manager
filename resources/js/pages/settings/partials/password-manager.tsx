import LoadingButton from '@/components/loading-button';
import PasswordInputWithError from '@/components/password-input-with-error';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';

type ProfileForm = {
    current_password: string;
    password: string;
    password_confirmation: string;
};

function PasswordManager() {
    const { data, setData, put, processing, reset } = useForm<Required<ProfileForm>>({
        current_password: '',
        password: '',
        password_confirmation: '',
    });

    const handelPasswordChange: FormEventHandler = (e) => {
        e.preventDefault();

        put(route('password.update'), {
            preserveScroll: true,
            onError: (e) => {
                if (e.current_password) {
                    reset('current_password');
                }
                if (e.password) {
                    reset('password', 'password_confirmation');
                }
            },
            onSuccess: () => {
                reset('current_password', 'password', 'password_confirmation');
            },
        });
    };
    return (
        <div className="flex w-full items-center justify-center">
            <Card className="w-full">
                <form onSubmit={handelPasswordChange} className="w-full space-y-6">
                    <CardHeader>
                        <CardTitle>Password Manager</CardTitle>
                        <CardDescription>Enter your current Password and a new secure password.</CardDescription>
                    </CardHeader>
                    <CardContent className="flex justify-center">
                        <div className="grid w-full grid-cols-1 gap-4 md:w-1/2">
                            <div className="grid gap-2">
                                <PasswordInputWithError
                                    label="Current Password"
                                    name="current_password"
                                    forgotPassword={false}
                                    required
                                    autoFocus
                                    tabIndex={1}
                                    autoComplete="current_password"
                                    value={data.current_password}
                                    onChange={(e) => setData('current_password', e.target.value)}
                                />
                            </div>

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
                                />
                            </div>

                            <div className="grid gap-2">
                                <PasswordInputWithError
                                    label="Confirm Password"
                                    name="password_confirmation"
                                    forgotPassword={false}
                                    required
                                    tabIndex={3}
                                    autoComplete="password_confirmation"
                                    value={data.password_confirmation}
                                    onChange={(e) => setData('password_confirmation', e.target.value)}
                                />
                            </div>
                        </div>
                    </CardContent>
                    <CardFooter className="flex items-center justify-end">
                        <LoadingButton processing={processing} text="Update Profile" tabIndex={4} />
                    </CardFooter>
                </form>
            </Card>
        </div>
    );
}

export default PasswordManager;
