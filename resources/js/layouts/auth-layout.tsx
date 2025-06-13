import Alert from '@/components/alert';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { usePage } from '@inertiajs/react';
import { GalleryVerticalEnd } from 'lucide-react';
import { type PropsWithChildren } from 'react';

export default function AuthLayout({
    children,
    title,
    description,
}: PropsWithChildren<{
    name?: string;
    title?: string;
    description?: string;
}>) {
    const pageProps = usePage().props;
    const appName = pageProps.name as string;

    return (
        <div className="bg-muted flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div className="flex w-full max-w-sm flex-col gap-6">
                <a href="#" className="flex items-center gap-2 self-center font-medium">
                    <div className="bg-primary text-primary-foreground flex size-6 items-center justify-center rounded-md">
                        <GalleryVerticalEnd className="size-4" />
                    </div>
                    {appName}
                </a>
                <div className="flex flex-col gap-6">
                    <Card>
                        <CardHeader className="px-10 pt-8 pb-0 text-center">
                            <Alert />
                            <CardTitle className="text-xl">{title}</CardTitle>
                            <CardDescription>{description}</CardDescription>
                        </CardHeader>
                        <CardContent className="px-10 py-8">{children}</CardContent>
                    </Card>
                    <div className="text-muted-foreground *:[a]:hover:text-primary text-center text-xs text-balance *:[a]:underline *:[a]:underline-offset-4">
                        V0.0.1. Developed and maintained by <a href="#">The Avengers</a>.
                    </div>
                </div>
            </div>
        </div>
    );
}
