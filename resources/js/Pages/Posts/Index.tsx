import React from 'react';
import useTypedPage from "@/Hooks/useTypedPage";
import AppLayout from "@/Layouts/AppLayout";
import { Session } from '@/types';
import Pagination from '@/Components/Pagination';
import { Link } from '@inertiajs/react';
import { formatDistance } from 'date-fns';
import { route } from '../../../../vendor/tightenco/ziggy';
import PageHeading from '@/Components/PageHeading';
import clsx from 'clsx';
import InputLabel from '@/Components/InputLabel';
import { useForm } from '@inertiajs/react';
import TextInput from '@/Components/TextInput';
import SecondaryButton from '@/Components/SecondaryButton';

export default function Index({post, posts, selectedTopic, topics, query}:{post:any, posts:any,selectedTopic:any, topics:any, query:string}
    ){

    const page = useTypedPage();

    console.log(" Page ******* ", page);
    const searchForm = useForm({
        'query': query,
        'page': 1
    })

    const submit = (e) => {
        e.preventDefault();
        searchForm.get(page.url);
    }

    console.log('posts', posts);
    return(
        <AppLayout

        title={'Posts'}
        renderHeader={() => (
            <PageHeading>
                {selectedTopic ? selectedTopic.name : 'All Posts'}
                <div className={"flex flex-col md:flex-row justify-between items-center"}>
                    <div className={"flex flex-wrap space-x-2 space-y-2 mt-4 pb-2 pt-1 text-nowrap  items-baseline"}>
                        <Link id={"posts.index"} href={route('posts.index', {query: searchForm.data.query})} className={clsx("rounded-full py-0.5 px-2 border border-blue-300 text-blue-300 hover:bg-indigo-500 hover:text-white ml-2", !selectedTopic && "bg-indigo-500 !text-white" )} >
                            All Posts
                        </Link>
                        {topics && topics.map((topic:any) => (
                            <Link key={topic.id} href={route('posts.index', {topic: topic.slug, query: searchForm.data.query})} className={clsx("rounded-full py-0.5 px-2 border border-blue-300 text-blue-300 hover:bg-indigo-500 hover:text-white", topic.slug === selectedTopic?.slug && "bg-indigo-500 !text-white")} >
                                {topic.name}
                            </Link>
                        ))}
                    </div>
                    <form onSubmit={submit}>
                        <div className={"flex flex-row items-center space-x-4 font-bold"}>
                            {/*<InputLabel htmlFor="query" >Search</InputLabel>*/}
                            <TextInput id={"query"}  className={"mt-1 w-full md:w-56"} placeholder={"Search..."} value={searchForm.data.query} onChange={(e) => searchForm.setData('query',e.target.value)}/>
                            <SecondaryButton>Search</SecondaryButton>
                        </div>
                    </form>

                </div>
            </PageHeading>
        )}

        >
            <div>
              <div className='max-w-5xl mx-auto'>

              <ul className='divide-y-2'>

                {posts &&
                  posts.data.map((post:any) => {
                      const formattedDate = formatDistance(post?.created_at || new Date(), new Date(), {addSuffix:true});
                      return(
                            <li key={post.id} className=' py-4 px-2 flex justify-between  items-baseline flex-col md:flex-row'>
                                <Link href={post.routes.show} className={"group"} >
                                    <span className={"text-lg font-bold group-hover:text-indigo-600"}>
                                        {post.title}
                                    </span>
                                    <div className="text-gray-600 mb-2 font-normal">
                                        {formattedDate} by {post?.user.name}
                                    </div>

                                </Link>
                                <Link href={route('posts.index', {topic: post.topic.slug})} className={"rounded-full py-0.5 px-2 border border-blue-300 text-blue-300 hover:bg-indigo-500"} >
                                    {post.topic.name}
                                </Link>

                            </li>
                          )
                  })
                }
              </ul>
              </div>
              <Pagination meta={posts.meta}  only={['posts']}  links={posts.links}/>

            </div>
        </AppLayout>
    );
}
