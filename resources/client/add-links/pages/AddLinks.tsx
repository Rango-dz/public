import React, {useId, useState} from 'react'
import {SitePageLayout} from '@app/site-page-layout';
import {Trans} from '@common/i18n/trans';
import {List, ListItem} from '@common/ui/list/list';
import {useForm} from 'react-hook-form';
import {Button} from '@common/ui/buttons/button';
import { AccountSettingsPanel } from '@common/auth/ui/account-settings/account-settings-panel';
import {apiClient} from '@common/http/query-client';
import {title_types, FormValues, id_type, categories, video_type, video_category, quality, STORE_URL} from '../models/AddLinks'
import { useNavigate } from '@common/utils/hooks/use-navigate';
import {SearchAutocomplete} from '@app/search/search-autocomplete';
import { Title } from "@app/titles/models/title";

export default function AddLinks() {
    const formId = useId();
    const navigate = useNavigate();
    const [data, setData] = useState<Title>();

    const {
        register, 
        handleSubmit, 
        formState : {errors, isSubmitting},
        reset
    } = useForm<FormValues>({
        defaultValues : {
            language: "",
            video_category : "movie",
            video_type: "url",
            quality: "hd",
            src: ""
        }
    });
    const onSubmit = (formData: FormValues) => {
        console.log({...formData, id:data?.id});
        // apiClient.post(STORE_URL, data)
        // .then(response => {
        //     console.log(response?.data);
        //     reset();
        //     navigate('/movies');
        // })
        // .catch(error => {
        //     console.log(error.response?.data?.errors);
        // });
    }
    
  return (
    <SitePageLayout>
        <div className='min-h-screen bg-alt'>
            <div>
                <div className='container mx-auto my-24 px-24'>
                    <h1 className="text-3xl">
                        <Trans message="Add Links" />
                    </h1>
                    <div className='mb-40 text-base text-muted'>
                        <Trans message="Add Links for Movie and for Series" />
                    </div>
                    <div className='flex items-start gap-24'>
                        <aside className='sticky top-10 hidden flex-shrink-0 lg:block'>
                            <List padding="p-0">
                                <ListItem key={'links'}>
                                    <Trans message='Add Links'/>
                                </ListItem>
                            </List>

                        </aside>
                        <main className='flex-auto'>
                             <div className='flex flex-col flex-col-reverse md:flex-row items-center gap-40 md:gap-80'>
                                <div className='flex-auto w-full'>
                                    <div className='mb-24 text-sm'>
                                        <SearchAutocomplete className="max-md:hidden" transferDatatoParent={true} callback={setData} />
                                    </div>
                                </div>
                            </div>
                            {
                                data ? 
                                <AccountSettingsPanel
                                id={'links'}
                                title={<Trans message='Add Links'/>}
                                actions={
                                    <Button
                                    type="submit"
                                    variant="flat"
                                    color="primary"
                                    form={formId}
                                    disabled={isSubmitting}
                                    >
                                        <Trans message="Save" />
                                    </Button>
                                    }>
                                        <form
                                            className="flex flex-col flex-col-reverse md:flex-row items-center gap-40 md:gap-80"
                                            onSubmit={handleSubmit(onSubmit)}
                                            id={formId}
                                        >
                                            <div className="flex-auto w-full">
                                                <div className="mb-24 text-sm">
                                                    <label className="block first-letter:capitalize text-left whitespace-nowrap text-sm mb-4">Language (optional)</label>
                                                    <div className="isolate relative">
                                                        <input {...register('language')}  name="language"  className="block text-left relative w-full appearance-none transition-shadow text bg-transparent rounded-input border-divider border focus:ring focus:ring-primary/focus focus:border-primary/60 focus:outline-none shadow-sm text-sm h-42 pl-12 pr-12"/>
                                                    </div>
                                                </div>
                                                <div className="mb-24 text-sm">
                                                    <label className="block first-letter:capitalize text-left whitespace-nowrap text-sm mb-4">Video Quality</label>
                                                    <div className="isolate relative">
                                                        <select {...register('quality', {required : 'Quality is required field.'})} name='qulity' className='block w-full relative h-42 pl-12 pr-12 appearance-none transition-shadow  rounded-input border-divider'>
                                                            {
                                                                quality.map((value, id) => {
                                                                    return (
                                                                        <option key={'quality-' + id} value={value}>{value}</option>
                                                                    )
                                                                })
                                                            }
                                                        </select>
                                                        {errors.quality && (
                                                            <p className='text-red-500'>{`${errors.quality.message}`}</p>
                                                        )}
                                                    </div>
                                                </div>
                                                <div className="mb-24 text-sm">
                                                    <label className="block first-letter:capitalize text-left whitespace-nowrap text-sm mb-4">Video Type</label>
                                                    <div className="isolate relative">
                                                        <select {...register('video_type', {required : 'Video type is required field.'})} name='vide_type' className='block w-full relative h-42 pl-12 pr-12 appearance-none transition-shadow  rounded-input border-divider'>
                                                            {
                                                                video_type.map((value, id) => {
                                                                    return (
                                                                        <option key={'video-type-' + id} value={value}>{value}</option>
                                                                    )
                                                                })
                                                            }
                                                        </select>
                                                        {errors.video_type && (
                                                            <p className='text-red-500'>{`${errors.video_type.message}`}</p>
                                                        )}
                                                    </div>
                                                </div>
                                                <div className="mb-24 text-sm">
                                                    <label className="block first-letter:capitalize text-left whitespace-nowrap text-sm mb-4">Video Category</label>
                                                    <div className="isolate relative">
                                                        <select {...register('video_category', {required : 'Video category is required field.'})} name='video_category' className='block w-full relative h-42 pl-12 pr-12 appearance-none transition-shadow  rounded-input border-divider'>
                                                            {
                                                                video_category.map((value, id) => {
                                                                    return (
                                                                        <option key={'video-category-' + id} value={value}>{value}</option>
                                                                    )
                                                                })
                                                            }
    
                                                        </select>
                                                        {errors.video_category && (
                                                            <p className='text-red-500'>{`${errors.video_category.message}`}</p>
                                                        )}
                                                    </div>
                                                </div>
                                                <div className="mb-24 text-sm">
                                                    <label className="block first-letter:capitalize text-left whitespace-nowrap text-sm mb-4">Video Src (Each url separated by comma)</label>
                                                    <div className="isolate relative">
                                                        <input {...register('src', {
                                                            required: 'Video is required field.',
                                                        })}  name="src"  className="block text-left relative w-full appearance-none transition-shadow text bg-transparent rounded-input border-divider border focus:ring focus:ring-primary/focus focus:border-primary/60 focus:outline-none shadow-sm text-sm h-42 pl-12 pr-12"/>
                                                    </div>
                                                    {errors.src && (
                                                            <p className='text-red-600'>{`${errors.src.message}`}</p>
                                                    )}
                                                </div>
                                            </div>
                                        </form>
                                </AccountSettingsPanel>   
                                : ''
                            }         
                        </main>
                    </div>
                </div>
            </div>
        </div>
    </SitePageLayout>
  )
}
