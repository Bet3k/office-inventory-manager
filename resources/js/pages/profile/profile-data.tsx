import InputWithError from '@/components/input-with-error';
import LoadingButton from '@/components/loading-button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { SharedData } from '@/types';
import { Link, useForm, usePage } from '@inertiajs/react';
import { FormEventHandler } from 'react';

type ProfileForm = {
    first_name: string;
    last_name: string;
    email: string;
};

function ProfileData() {
    const { auth } = usePage<SharedData>().props;

    const { data, setData, put, processing } = useForm<Required<ProfileForm>>({
        first_name: auth.user.profile.first_name,
        last_name: auth.user.profile.last_name,
        email: auth.user.email,
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        put(route('profile.update', auth.user.profile.id), {
            preserveScroll: true,
        });
    };
    return (
        <div className="flex w-full items-center justify-center p-4">
            <Card className="w-full md:w-1/2">
                <form onSubmit={submit} className="space-y-6">
                    <CardHeader>
                        <CardTitle>Profile Details</CardTitle>
                        <CardDescription>Your profile information. Did we capture correct information?</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div className="grid gap-2">
                                <InputWithError
                                    label="First Name"
                                    name="first_name"
                                    type="text"
                                    required
                                    autoFocus
                                    tabIndex={1}
                                    autoComplete="first_name"
                                    value={data.first_name}
                                    onChange={(e) => setData('first_name', e.target.value)}
                                    placeholder="John"
                                />
                            </div>

                            <div className="grid gap-2">
                                <InputWithError
                                    label="Last Name"
                                    name="last_name"
                                    type="test"
                                    required
                                    tabIndex={2}
                                    autoComplete="last_name"
                                    value={data.last_name}
                                    onChange={(e) => setData('last_name', e.target.value)}
                                    placeholder="Doe"
                                />
                            </div>
                        </div>
                        <div className="mt-2 grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div className="grid gap-2">
                                <InputWithError
                                    label="Email Address"
                                    name="email"
                                    type="email"
                                    required
                                    autoComplete="email"
                                    value={data.email}
                                    onChange={(e) => setData('email', e.target.value)}
                                    placeholder="email@example.com"
                                />
                                {auth.user.email_verified_at === null && (
                                    <p className="text-muted-foreground text-sm">
                                        Your email address is unverified.{' '}
                                        <Link
                                            href={route('verify-email.store')}
                                            method="post"
                                            as="button"
                                            className="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                                        >
                                            Click here to resend the verification email.
                                        </Link>
                                    </p>
                                )}
                            </div>
                        </div>
                    </CardContent>
                    <CardFooter className="flex items-center justify-end">
                        <LoadingButton processing={processing} text="Update Profile" />
                    </CardFooter>
                </form>
            </Card>
        </div>
    );
}

export default ProfileData;
