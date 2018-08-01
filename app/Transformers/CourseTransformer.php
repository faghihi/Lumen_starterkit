<?php
namespace App\Transformers;
use League\Fractal\TransformerAbstract;
use Modules\Course\Entities\Course;

class CourseTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include.
     *
     * @var array
     */
    protected $availableIncludes = [
        'description',
        'users'
    ];
    /**
     * A Fractal transformer.
     *
     * @param Course $course
     *
     * @return array
     */
    public function transform(Course $course)
    {
        return [
            'name' => $course['name'],
            'image' => $course['image']
        ];
    }
    /**
     * Include description.
     *
     * @param Course $course
     *
     * @return \League\Fractal\ItemResource
     */
    public function includeDescription(Course $course)
    {
        $description = $course->description;
        return $this->item([$description], function ($description) {
            return $description;
        });
    }
    /**
     * Include users.
     *
     * @param Course $course
     *
     * @return \League\Fractal\CollectionResource
     */
    public function includeUsers(Course $course)
    {
        $users = $course->users()->get();
        return $this->collection($users, function ($user) {
            return [
                'name' => $user['name'],
                'image' => $user['image'],
            ];
        });
    }
}