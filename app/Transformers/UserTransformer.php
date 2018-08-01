<?php
namespace App\Transformers;
use League\Fractal\TransformerAbstract;
use App\User;
use Modules\Course\Entities\Course;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include.
     *
     * @var array
     */
    protected $availableIncludes = [
        'email',
        'courses',
    ];
    /**
     * A Fractal transformer.
     *
     * @param User $user
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'name' => $user['name'],
            'image' => $user['image']
        ];
    }
    /**
     * Include description.
     *
     * @param User $user
     *
     * @return \League\Fractal\ItemResource
     */
    public function includeEmail(User $user)
    {
        $email = $user->email;
        return $this->item([$email], function ($email) {
            return $email;
        });
    }
    /**
     * Include courses.
     *
     * @param User $user
     *
     * @return \League\Fractal\CollectionResource
     */
    public function includeCourses(User $user)
    {
        $courses = $user->courses()->get();
        return $this->collection($courses, function (Course $course) {
            return [
                'name' => $course['name'],
                'image' => $course['image']
            ];
        });
    }
}