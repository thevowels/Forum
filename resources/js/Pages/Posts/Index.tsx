import React from 'react';
import useTypedPage from "@/Hooks/useTypedPage";
import AppLayout from "@/Layouts/AppLayout";
import { Session } from '@/types';
import Pagination from '@/Components/Pagination';
import { Link } from '@inertiajs/react';
import { formatDistance } from 'date-fns';
import { route } from '../../../../vendor/tightenco/ziggy';


export default function Index({posts,post}:{post:any, posts:any}
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
              <div className='max-w-5xl mx-auto'>

              <ul className='divide-y-2'>

                {posts &&
                  posts.data.map((post:any) => {
                      const formattedDate = formatDistance(post?.created_at || new Date(), new Date());
                      return(
                            <li key={post.id} className=' py-4 px-2 flex justify-between  items-baseline flex-col md:flex-row'>
                                <Link href={post.routes.show} className={"group"} >
                                    <span className={"text-lg font-bold group-hover:text-indigo-600"}>
                                        {post.title}
                                    </span>
                                    <div className="text-gray-600 mb-2 font-normal">
                                        {formattedDate} Ago by
                                            {post?.user.name}

                                    </div>

                                </Link>
                                <Link href={"/"} className={"rounded-full py-0.5 px-2 border border-blue-300 text-blue-300 hover:bg-indigo-500"} >
                                    {post.topic.name}
                                </Link>

                            </li>
                          )
                  })
                }
              </ul>
              </div>
              <Pagination meta={posts.meta} links = {posts.links} only={['posts']}/>

            </div>
        </AppLayout>
    );
}
