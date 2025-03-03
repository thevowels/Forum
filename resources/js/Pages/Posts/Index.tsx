import React from 'react';
import useTypedPage from "@/Hooks/useTypedPage";
import AppLayout from "@/Layouts/AppLayout";
import { Session } from '@/types';
import Pagination from '@/Components/Pagination';


interface Props {

  confirmsTwoFactorAuthentication: boolean;
}

export default function Index({posts}:{posts:any}
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
              <div className='max-w-xl mx-auto'>

              <ul className='divide-y-2'>

                {posts && 
                  posts.data.map((post:any) => (
                    <li key={post.id} className=' py-4 px-2'>
                      {post.title}
                    </li>
                  ))
                }
              </ul>
              </div>
              <Pagination meta={posts.meta} links = {posts.links}/>

            </div>
        </AppLayout>
    );
}