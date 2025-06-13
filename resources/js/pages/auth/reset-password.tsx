import LoadingButton from '@/components/loading-button';
import PasswordInputWithError from '@/components/password-input-with-error';
import TextLink from '@/components/text-link';
import AuthLayout from '@/layouts/auth-layout';
import { Head, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';

type ResetPasswordForm = {
    token: string;
    id: string;
    password: string;
    password_confirmation: string;
};

interface ResetPasswordProps {
    token: string;
    id: string;
}

export default function ResetPassword({ token, id }: ResetPasswordProps) {
    const { data, setData, post, processing, reset } = useForm<Required<ResetPasswordForm>>({
        token: token,
        id: id,
        password: '',
        password_confirmation: '',
    });

    const handelRegister: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('password.store'), {
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };
    return (
        <AuthLayout title="Set Password" description="Enter your new secure password.">
            <Head title="Set Password" />

            <form className="flex flex-col gap-4" onSubmit={handelRegister}>
                <div className="grid gap-4">
                    <div className="grid gap-2">
                        <PasswordInputWithError
                            label="Password"
                            name="password"
                            forgotPassword={false}
                            required
                            tabIndex={1}
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
                            tabIndex={2}
                            autoComplete="password_confirmation"
                            value={data.password_confirmation}
                            onChange={(e) => setData('password_confirmation', e.target.value)}
                        />
                    </div>
                    <LoadingButton processing={processing} text="Save" tabIndex={3} fullWidth={true} />
                </div>

                <div className="text-muted-foreground text-center text-sm">
                    Already have an account?{' '}
                    <TextLink href={route('login')} tabIndex={4}>
                        Log in
                    </TextLink>
                </div>
            </form>
        </AuthLayout>
    );
}
