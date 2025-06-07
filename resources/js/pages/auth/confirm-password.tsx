import LoadingButton from '@/components/loading-button';
import PasswordInputWithError from '@/components/password-input-with-error';
import Layout from '@/layouts/auth-layout';
import { Head, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';

export default function ConfirmPassword() {
    const { data, setData, post, processing, reset } = useForm<Required<{ password: string }>>({
        password: '',
    });

    const handelSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('password.confirm'), {
            onFinish: () => reset('password'),
        });
    };
    return (
        <Layout title="Password COnfirmation" description="Entrer your password to confirm your identity">
            <Head title="confirm-password" />

            <form onSubmit={handelSubmit} className="flex flex-col gap-6">
                <div className="grid gap-6">
                    <div className="grid gap-6">
                        <div className="grid gap-2">
                            <PasswordInputWithError
                                label="Password"
                                name="password"
                                forgotPassword={false}
                                forgotPasswordLink={route('forgot-password.create')}
                                required
                                tabIndex={2}
                                autoComplete="password"
                                value={data.password}
                                onChange={(e) => setData('password', e.target.value)}
                                placeholder="••••••••"
                            />
                        </div>
                        <LoadingButton processing={processing} text="Log in" tabIndex={4} fullWidth={true} />
                    </div>
                </div>
            </form>
        </Layout>
    );
}
