import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Drawer, DrawerContent, DrawerDescription, DrawerHeader, DrawerTitle, DrawerTrigger } from '@/components/ui/drawer';
import * as React from 'react';
import { useMediaQuery } from 'usehooks-ts';

type DialogDrawerProps = {
    title: string;
    description?: string;
    triggerText: string;
    btnFull?: boolean;
    btnType?: 'default' | 'destructive' | 'outline' | 'secondary';
    children: React.ReactNode | ((params: { close: () => void }) => React.ReactNode);
};

export function DialogDrawer({ title, description, triggerText, btnFull = false, btnType = 'default', children }: DialogDrawerProps) {
    const [open, setOpen] = React.useState(false);
    const isDesktop = useMediaQuery('(min-width: 768px)');
    const close = () => setOpen(false);

    const renderContent = typeof children === 'function' ? children({ close }) : children;

    if (isDesktop) {
        return (
            <Dialog open={open} onOpenChange={setOpen}>
                <DialogTrigger asChild>
                    <Button variant={btnType} className={btnFull ? 'w-full' : undefined}>
                        {triggerText}
                    </Button>
                </DialogTrigger>
                <DialogContent className="w-full">
                    <DialogHeader>
                        <DialogTitle>{title}</DialogTitle>
                        {description && <DialogDescription>{description}</DialogDescription>}
                    </DialogHeader>
                    {renderContent}
                </DialogContent>
            </Dialog>
        );
    }

    return (
        <Drawer open={open} onOpenChange={setOpen}>
            <DrawerTrigger asChild>
                <Button variant={btnType} className={btnFull ? 'w-full' : undefined}>
                    {triggerText}
                </Button>
            </DrawerTrigger>
            <DrawerContent className="p-4">
                <DrawerHeader className="text-left">
                    <DrawerTitle>{title}</DrawerTitle>
                    {description && <DrawerDescription>{description}</DrawerDescription>}
                </DrawerHeader>
                {renderContent}
            </DrawerContent>
        </Drawer>
    );
}
