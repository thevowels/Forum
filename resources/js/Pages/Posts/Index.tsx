import React from 'react';
import useTypedPage from "@/Hooks/useTypedPage";
import AppLayout from "@/Layouts/AppLayout";
import { Session } from '@/types';


interface Props {

  confirmsTwoFactorAuthentication: boolean;
}

export default function Index({posts}:{posts:any[]}
    ){

    const page = useTypedPage();

    console.log('posts', posts);
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
              <ul>

                {posts && 
                  posts.map((post) => (
                    <li key={post.id}>
                      {post.title}
                    </li>
                  ))
                }
              </ul>

            </div>
        </AppLayout>
    );
}