import React from 'react';
import useTypedPage from "@/Hooks/useTypedPage";
import AppLayout from "@/Layouts/AppLayout";
import { Session } from '@/types';


interface Props {
  sessions: Session[];
  confirmsTwoFactorAuthentication: boolean;
}

export default function Index({
    sessions,
    confirmsTwoFactorAuthentication,
}:Props){

    const page = useTypedPage();
    return(
        <AppLayout
        
        title={'Profile'}
        renderHeader={() => (
          <h2 className="font-semibold text-xl text-gray-800 leading-tight">
            Profile
          </h2>
        )}
  
        >
            <div>
                ASDFASDF
            </div>
        </AppLayout>
    );
}