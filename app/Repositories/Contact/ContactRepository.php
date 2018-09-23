<?php

namespace Fully\Repositories\Contact;

use Config;
use Fully\Models\Contact;
use Response;
use Fully\Repositories\RepositoryAbstract;
use Fully\Repositories\CrudableInterface;
use Fully\Exceptions\Validation\ValidationException;

/**
 * Class ContactRepository.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class ContactRepository extends RepositoryAbstract implements ContactInterface, CrudableInterface
{
    /**
     * @var
     */
    protected $perPage;

    /**
     * @var \Contact
     */
    protected $contact;

    /**
     * Rules.
     *
     * @var array
     */
    protected static $rules = [
        'company_name' => 'required',
        'address' => 'required',
        'phone_number' => 'required',
        'email' => 'required',
    ];

    public function __construct(Contact $contact)
    {
        $config = Config::get('fully');
        $this->contact = $contact;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->contact->orderBy('created_at', 'DESC')
            ->where('is_published', 1)->where('lang', $this->getLang())
            ->get();
    }

    /**
     * @return mixed
     */
    public function lists()
    {
        return $this->contact->get()->where('lang', $this->getLang())->lists('company_name', 'id');
    }

    /**
     * Get paginated contact.
     *
     * @param int  $page  Number of news per page
     * @param int  $limit Results per page
     * @param bool $all   Show published or all
     *
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function paginate($page = 1, $limit = 10, $all = false)
    {
        $result = new \StdClass();
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        $query = $this->contact->orderBy('created_at', 'DESC')->where('lang', $this->getLang());

        if (!$all) {
            $query->where('is_published', 1);
        }

        $contact = $query->skip($limit * ($page - 1))
            ->take($limit)
            ->get();

        $result->totalItems = $this->totalContact($all);
        $result->items = $contact->all();

        return $result;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->contact->findOrFail($id);
    }

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug)
    {
        return $this->contact->where('slug', $slug)->first();
    }

    /**
     * @param $attributes
     *
     * @return bool|mixed
     *
     * @throws \Fully\Exceptions\Validation\ValidationException
     */
    public function create($attributes)
    {
        $attributes['is_published'] = isset($attributes['is_published']) ? true : false;

        if ($this->isValid($attributes)) {

            $this->contact->lang = $this->getLang();
            $this->contact->fill($attributes)->save();

            return true;
        }

        throw new ValidationException('Contact validation failed', $this->getErrors());
    }

    /**
     * @param $id
     * @param $attributes
     *
     * @return bool|mixed
     *
     * @throws \Fully\Exceptions\Validation\ValidationException
     */
    public function update($id, $attributes)
    {
        $attributes['is_published'] = isset($attributes['is_published']) ? true : false;

        $this->contact = $this->find($id);

        if ($this->isValid($attributes)) {

            $this->contact->resluggify();
            $this->contact->fill($attributes)->save();

            return true;
        }

        throw new ValidationException('Contact validation failed', $this->getErrors());
    }

    /**
     * @param $id
     *
     * @return mixed|void
     */
    public function delete($id)
    {
        $this->contact->find($id)->delete();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function togglePublish($id)
    {
        $contact = $this->contact->find($id);
        $contact->is_published = ($contact->is_published) ? false : true;
        $contact->save();

        return Response::json(array('result' => 'success', 'changed' => ($contact->is_published) ? 1 : 0));
    }

    /**
     * Get total contact count.
     *
     * @param bool $all
     *
     * @return mixed
     */
    protected function totalContact($all = false)
    {
        if (!$all) {
            return $this->contact->where('is_published', 1)->where('lang', $this->getLang())->count();
        }

        return $this->contact->where('lang', $this->getLang())->count();
    }
}
