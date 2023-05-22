<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img src="/storage/servicio.svg" alt="" class="w-56 h-auto">
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('newUserInvited', ['email' => $email, 'permission' => $permission]) }}">
            <div x-data="{password: '', password_confirm: ''}">
                @csrf

                <div>
                    <x-jet-label for="name" value="{{ __('Name') }}" />
                    <x-jet-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                </div>

                <div class="mt-4">
                    <x-jet-label for="email" value="{{ __('Email') }}" />
                    <x-jet-input id="email" class="block w-full mt-1 bg-gray-50" type="email" name="email" :value="old('email')" value="{{ $email }}" readonly required />
                </div>

                <div class="mt-4">
                    <x-jet-label for="password" value="{{ __('Password') }}" />
                    <x-jet-input id="password" class="block w-full mt-1" type="password" name="password" x-model="password" required autocomplete="new-password" />
                </div>

                <div class="mt-4">
                    <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-jet-input id="password_confirmation" class="block w-full mt-1" type="password" name="password_confirmation" x-model="password_confirm" required autocomplete="new-password" />
                </div>

                <div class="flex justify-start p-1 mt-3 ml-4">
                    <ul>
                        <li class="flex items-center py-1">
                            <div :class="{'bg-green-200 text-green-700': password == password_confirm && password.length > 0, 'bg-red-200 text-red-700':password != password_confirm || password.length == 0}"
                                class="p-1 rounded-full fill-current ">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path x-show="password == password_confirm && password.length > 0" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"/>
                                    <path x-show="password != password_confirm || password.length == 0" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"/>

                                </svg>
                            </div>
                            <span :class="{'text-green-700': password == password_confirm && password.length > 0, 'text-red-700':password != password_confirm || password.length == 0}"
                                class="ml-3 text-sm font-medium"
                                x-text="password == password_confirm && password.length > 0 ? 'Coinciden las contraseñas' : 'No coinciden las contraseñas' "></span>
                        </li>
                        <li class="flex items-center py-1">
                            <div :class="{'bg-green-200 text-green-700': password.length > 7, 'bg-red-200 text-red-700':password.length < 7 }"
                                class="p-1 rounded-full fill-current ">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path x-show="password.length > 7" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"/>
                                    <path x-show="password.length < 7" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"/>

                                </svg>
                            </div>
                            <span :class="{'text-green-700': password.length > 7, 'text-red-700':password.length < 7 }"
                                class="ml-3 text-sm font-medium"
                                x-text="password.length > 7 ? 'El largo mínimo es correcto' : '8 carácteres requeridos' "></span>
                        </li>
                    </ul>
                </div>

                <x-inputs.hidden
                        name="roles[]"
                        value="{{ $permission }}"
                    ></x-inputs.hidden>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mt-4">
                        <x-jet-label for="terms">
                            <div class="flex items-center">
                                <x-jet-checkbox name="terms" id="terms"/>

                                <div class="ml-2">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="text-sm text-gray-600 underline hover:text-gray-900">'.__('Terms of Service').'</a>',
                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="text-sm text-gray-600 underline hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                    ]) !!}
                                </div>
                            </div>
                        </x-jet-label>
                    </div>
                @endif

                <div class="flex items-center justify-end mt-4">
                    <x-jet-button class="ml-4" x-bind:disabled="password != password_confirm || password.length == 0">
                        {{ __('Registrarse') }}
                    </x-jet-button>
                </div>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
