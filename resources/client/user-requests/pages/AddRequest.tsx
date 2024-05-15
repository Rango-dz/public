import React from 'react'
import {SitePageLayout} from '@app/site-page-layout';
import {Trans} from '@common/i18n/trans';
import {
    AccountSettingsSidenav,
  } from '@common/auth/ui/account-settings/account-settings-sidenav'; 
import UserRequestSideNav from '../components/UserRequestSideNav';
import MovieForm from '../components/MovieForm';

export default function AddRequest() {
  return (
    <SitePageLayout>
        <div className='min-h-screen bg-alt'>
            <div>
                <div className='container mx-auto my-24 px-24'>
                    <h1 className="text-3xl">
                        <Trans message="User Requests" />
                    </h1>
                    <div className='mb-40 text-base text-muted'>
                        <Trans message="Request your favourite movies, series and episodes." />
                    </div>
                    <div className='flex items-start gap-24'>
                        <UserRequestSideNav/>
                        <main className='flex-auto'>
                            <MovieForm></MovieForm>
                        </main>
                    </div>
                </div>
            </div>
        </div>
    </SitePageLayout>
  )
}
