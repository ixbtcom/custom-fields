<?php

namespace Webkul\CustomFields\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Webkul\CustomFields\Models\Field;
use Webkul\Security\Models\User;

class FieldPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_field_field');
    }

    public function view(User $user, Field $field): bool
    {
        return $user->can('view_field_field');
    }

    public function create(User $user): bool
    {
        return $user->can('create_field_field');
    }

    public function update(User $user, Field $field): bool
    {
        return $user->can('update_field_field');
    }

    public function delete(User $user, Field $field): bool
    {
        return $user->can('delete_field_field');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_field_field');
    }

    public function forceDelete(User $user, Field $field): bool
    {
        return $user->can('force_delete_field_field');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_field_field');
    }

    public function restore(User $user, Field $field): bool
    {
        return $user->can('restore_field_field');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_field_field');
    }
}
