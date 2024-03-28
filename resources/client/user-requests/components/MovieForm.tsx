import React, {useId, useState} from 'react'
import {useForm} from 'react-hook-form';
import {Button} from '@common/ui/buttons/button';
import { AccountSettingsPanel } from '@common/auth/ui/account-settings/account-settings-panel';
import { UserRequestId } from './UserRequestSideNav';
import { Trans } from '@common/i18n/trans';
import {SearchAutocomplete} from '@app/search/search-autocomplete';
import { Title } from "@app/titles/models/title";
import {apiClient} from '@common/http/query-client';
import { useNavigate } from '@common/utils/hooks/use-navigate';
import { POST_URL, GET_URL } from '../Models/UserRequest';

export default function MovieForm() {
  const [data, setData] = useState<Title>();  
  const formId = useId();
  const navigate = useNavigate();

  const {register, handleSubmit} = useForm({
    defaultValues : {
        season_no : "",
        episode_no : "",
        description : ""
    }
  });  
  const onSubmit  = (e) => {
    if (data?.id) {
        apiClient.post(POST_URL, {...e, title_id : data.id})
        .then(response => {
            console.log(response);
            navigate('/' + GET_URL)
        })
        .catch(err => {
            console.log(err);
        });
    }
  };
  return (
    <AccountSettingsPanel
     id={UserRequestId.Movie}
     title={<Trans message='Add Movie'/>}
     actions={
        <Button
        type="submit"
        variant="flat"
        color="primary"
        form={formId}
        >
            <Trans message="Request" />
        </Button>
        }
        
    >
        <div className='flex flex-col flex-col-reverse md:flex-row items-center gap-40 md:gap-80'>
            <div className='flex-auto w-full'>
                <div className='mb-24 text-sm'>
                    <SearchAutocomplete className="max-md:hidden" transferDatatoParent={true} callback={setData} />
                </div>
            </div>
        </div>
        <form
            className="flex flex-col flex-col-reverse md:flex-row items-center gap-40 md:gap-80"
            onSubmit={handleSubmit(onSubmit)}
            id={formId}
        >
          <div className="flex-auto w-full">
            <div className="mb-24 text-sm">
                <label className="block first-letter:capitalize text-left whitespace-nowrap text-sm mb-4">Season No (optional)</label>
                <div className="isolate relative">
                    <input {...register('season_no')} disabled={!data?.is_series}  name="season_no"  className="block text-left relative w-full appearance-none transition-shadow text bg-transparent rounded-input border-divider border focus:ring focus:ring-primary/focus focus:border-primary/60 focus:outline-none shadow-sm text-sm h-42 pl-12 pr-12"/>
                </div>
            </div>
            <div className="mb-24 text-sm">
                <label className="block first-letter:capitalize text-left whitespace-nowrap text-sm mb-4">Episode No (optional)</label>
                <div className="isolate relative">
                    <input {...register('episode_no')} disabled={!data?.is_series}  name="episode_no"  className="block text-left relative w-full appearance-none transition-shadow text bg-transparent rounded-input border-divider border focus:ring focus:ring-primary/focus focus:border-primary/60 focus:outline-none shadow-sm text-sm h-42 pl-12 pr-12"/>
                </div>
            </div>
            <div className="mb-24 text-sm">
                <label className="block first-letter:capitalize text-left whitespace-nowrap text-sm mb-4">Description</label>
                <div className="isolate relative">
                    <input {...register('description')}  name="description"  className="block text-left relative w-full appearance-none transition-shadow text bg-transparent rounded-input border-divider border focus:ring focus:ring-primary/focus focus:border-primary/60 focus:outline-none shadow-sm text-sm h-42 pl-12 pr-12"/>
                </div>
            </div>
          </div>
        </form>
    </AccountSettingsPanel>
  )
}
