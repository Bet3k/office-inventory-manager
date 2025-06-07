import React from 'react';
import { LoaderCircle } from 'lucide-react';
import { Button } from '@/components/ui/button';

function LoadingButton({ processing, text, tabIndex, fullWidth, destructive }: {
    processing: boolean,
    text: string,
    tabIndex?: number,
    fullWidth?: boolean
    destructive?: boolean
}) {
    return (
        <Button className={fullWidth ? 'w-full' : ''} disabled={processing} tabIndex={tabIndex}
                variant={destructive ? 'destructive' : 'default'}>
            {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
            {text}
        </Button>
    );
}

export default LoadingButton;
