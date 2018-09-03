<?php

namespace Fully\Repositories\Author;

use Config;
use Fully\Models\Author;
use Fully\Repositories\RepositoryAbstract;
use Fully\Repositories\CrudableInterface;
use Fully\Exceptions\Validation\ValidationException;

/**
 * Class NewsRepository.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
class AuthorRepository extends RepositoryAbstract implements AuthorInterface, CrudableInterface {

    /**
     * @var
     */
    protected $perPage;

    /**
     * @var \Author
     */
    protected $author;

    /**
     * Rules.
     *
     * @var array
     */
    protected static $rules = [

    ];

    public function __construct(Author $author) {
        $config = Config::get('fully');
        $this->perPage = $config['per_page'];
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function all() {
        return $this->author->orderBy('id', 'DESC')->get();
    }
    
    /**
     * @return mixed
     */
    public function lists() {
        return $this->author->lists('name', 'id');
    }
    
    /**
     * Get paginated news.
     *
     * @param int  $page  Number of news per page
     * @param int  $limit Results per page
     * @param bool $all   Show published or all
     *
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function paginate($page = 1, $limit = 10, $all = false) {
        $result = new \StdClass();
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        $query = $this->author->orderBy('id', 'DESC');
        
        $author = $query->skip($limit * ($page - 1))
                ->take($limit)
                ->get();

        $result->totalItems = $this->totalAuthor($all);
        $result->items = $author->all();

        return $result;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id) {
        return $this->author->findOrFail($id);
    }

    /**
     * @param $attributes
     *
     * @return bool|mixed
     *
     * @throws \Fully\Exceptions\Validation\ValidationException
     */
    public function create($attributes) {
        
        if ($this->isValid($attributes)) {
            
            $this->author->fill($attributes)->save();

            return true;
        }

        throw new ValidationException('Author validation failed', $this->getErrors());
    }

    /**
     * @param $id
     * @param $attributes
     *
     * @return bool|mixed
     *
     * @throws \Fully\Exceptions\Validation\ValidationException
     */
    public function update($id, $attributes) {
        $this->author = $this->find($id);

        if ($this->isValid($attributes)) {
            $this->author->fill($attributes)->save();

            return true;
        }

        throw new ValidationException('Author validation failed', $this->getErrors());
    }

    /**
     * @param $id
     *
     * @return mixed|void
     */
    public function delete($id) {
        $this->author->find($id)->delete();
    }

    /**
     * Get total news count.
     *
     * @param bool $all
     *
     * @return mixed
     */
    protected function totalAuthor() {
        return $this->author->count();
    }
    
    public function getNewsAuthor($news_author){
        return $this->author->where('id' , $news_author)->value('name');
    }
}
