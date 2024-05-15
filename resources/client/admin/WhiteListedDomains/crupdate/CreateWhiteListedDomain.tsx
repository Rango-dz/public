import React from 'react'
import {Dialog} from '@common/ui/overlays/dialog/dialog';
import {DialogHeader} from '@common/ui/overlays/dialog/dialog-header';
import {Trans} from '@common/i18n/trans';
import {DialogBody} from '@common/ui/overlays/dialog/dialog-body';
import {useDialogContext} from '@common/ui/overlays/dialog/dialog-context';
import {Button} from '@common/ui/buttons/button';
import {useForm} from 'react-hook-form';
import {DialogFooter} from '@common/ui/overlays/dialog/dialog-footer';
import {apiClient} from '@common/http/query-client';
import { WhiteListedDomainPayload, URL } from '../models/WhiteListedDomain';
import { useNavigate } from '@common/utils/hooks/use-navigate';

export default function CreateWhiteListedDomain() {
    const {formId, close} = useDialogContext();
    const navigate = useNavigate();

    const {register, handleSubmit, formState : {errors, isSubmitting}, reset} = useForm<WhiteListedDomainPayload>({
        defaultValues : {
            name : ""
        }
    });

    const onSubmit = (data: WhiteListedDomainPayload) => {
        console.log(data);
        apiClient.post(URL, data)
        .then(response => {
            reset();
            close();
            navigate('/admin/white-listed-domains')
            console.log(response);
        })
        .catch(error => {
            console.log(error);
        })
    }
  return (
    <Dialog>
    <DialogHeader>
      <Trans message="Add WhiteListed Domain"/>
    </DialogHeader>
    <DialogBody>
        <form
            className="flex flex-col flex-col-reverse md:flex-row items-center gap-40 md:gap-80"
            onSubmit={handleSubmit(onSubmit)}
            id={formId}
        >
            <div className='flex-auto w-full'>
                <div className="mb-24 text-sm">
                    <label className="block first-letter:capitalize text-left whitespace-nowrap text-sm mb-4">Name</label>
                    <div className="isolate relative">
                        <input {...register('name', {required : 'Name is required field.',})} name="name"  className="block text-left relative w-full appearance-none transition-shadow text bg-transparent rounded-input border-divider border focus:ring focus:ring-primary/focus focus:border-primary/60 focus:outline-none shadow-sm text-sm h-42 pl-12 pr-12"/>
                        {errors.name && (
                            <p className='text-red-500'>{`${errors.name.message}`}</p>
                        )}
                    </div>
                </div>
            </div>

        </form>        
    </DialogBody>
    <DialogFooter>
      <Button onClick={() => close()}>
        <Trans message="Cancel" />
      </Button>
      <Button
        form={formId}
        type="submit"
        variant="flat"
        color="primary"
        disabled={isSubmitting}
      >
        <Trans message="Add" />
      </Button>
    </DialogFooter>
  </Dialog>
  )
}
