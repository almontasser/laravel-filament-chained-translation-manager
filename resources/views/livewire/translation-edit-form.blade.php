<div>
    <x-filament::card>
        <p class="">{{ $group . ' - '. $translationKey }}</p>
        <div class="text-base grid">
            @foreach($locales as $locale)
                <div
                    class="flex items-center"
                    x-data="{
                        editing: false,
                        openForm(){
                            $dispatch('close-forms');
                            this.editing = true;
                            $nextTick(() => {
                                setTimeout(() => {
                                    $refs.input.focus();
                                }, 50); //Adding a small delay makes this way more consistent
                            });
                        },
                        closeWithSave(){
                            if (this.editing){
                                this.closeEdit();
                                $wire.save(this.locale);
                            }
                        },
                        closeWithCancel(){
                            if (this.editing){
                                this.closeEdit();
                                $wire.cancel();
                            }
                        },
                        closeEdit() {
                            this.editing = false;
                        },
                        locale: '{{ $locale }}'
                    }"
                    @click.outside="closeWithSave"
                    @close-forms.window="closeWithSave()"
                >
                    <label
                        x-ref="label"
                        for="{{$this->group}}.{{$this->translationKey}}.translations.{{ $locale }}"
                        class="w-16"
                        x-bind:tabindex="!editing && '0'"
                        @focus="openForm"
                    >
                        {{ $locale }}:
                    </label>
                    <x-filament::link x-show="!editing" @click="openForm" class="w-full cursor-pointer">
                        <div class="w-full p-2">
                            {{ $translations[$locale] ?? null }}
                        </div>
                    </x-filament::link>
                    <div
                        x-show="editing"
                        class="block w-full flex items-center space-x-2"
                    >
                        <form @submit.prevent="closeWithSave" class="w-full">
                            <input
                                x-ref="input"
                                type="text"
                                id="{{$this->group}}.{{$this->translationKey}}.translations.{{ $locale }}"
                                class="{{
                                    'block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 border-gray-300' .
                                    (config('forms.dark_mode') ? 'dark:bg-gray-700 dark:text-white dark:focus:border-primary-500' : null)
                                }}"
                                wire:model.defer="translations.{{ $locale }}"
                            >
                        </form>
                        <div class="flex items-center align-center">
                            <button @click="closeWithCancel">
                                <x-heroicon-o-x class="w-5 h-5 text-danger-500"/>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::card>
</div>
