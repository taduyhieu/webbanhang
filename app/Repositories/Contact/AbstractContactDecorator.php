<?php

namespace Fully\Repositories\Contact;

/**
 * Class AbstractContactDecorator.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
abstract class AbstractContactDecorator implements ContactInterface
{
    /**
     * @var ContactInterface
     */
    protected $contact;

    /**
     * @param ContactInterface $contact
     */
    public function __construct(ContactInterface $contact)
    {
        $this->contact = $contact;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->contact->find($id);
    }

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug)
    {
        return $this->contact->getBySlug($slug);
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->contact->all();
    }

    /**
     * @param null $perPage
     * @param bool $all
     *
     * @return mixed
     */
    public function paginate($page = 1, $limit = 10, $all = false)
    {
        return $this->contact->paginate($page, $limit, $all);
    }
}
