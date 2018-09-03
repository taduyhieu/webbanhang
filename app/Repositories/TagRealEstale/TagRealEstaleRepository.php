<?php

namespace Fully\Repositories\TagRealEstale;

use Config;
use Fully\Models\TagRealEstale;
use Fully\Repositories\CrudableInterface;
use Fully\Repositories\RepositoryAbstract;
use Fully\Exceptions\Validation\ValidationException;
use Fully\Repositories\TagRealEstale\TagRealEstaleInterface;

/**
 * Class TagRealEstaleRepository.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
class TagRealEstaleRepository extends RepositoryAbstract implements TagRealEstaleInterface, CrudableInterface {

    /**
     * @var
     */
    protected $perPage;

    /**
     * @var \Comment
     */
    protected $tagRealEstale;

    /**
     * Rules.
     *
     * @var array
     */
    protected static $rules = [
//        'title' => 'required',
    ];

    /**
     * @param Tag $tag
     */
    public function __construct(TagRealEstale $tagRealEstale) {
        $this->tagRealEstale = $tagRealEstale;
        $config = Config::get('fully');
        $this->perPage = $config['per_page'];
    }

    /**
     * @return mixed
     */
    public function all() {
        return $this->tagRealEstale->get();
    }

    /**
     * Get paginated tags.
     *
     * @param int  $page  Number of coments per page
     * @param int  $limit Results per page
     * @param bool $all   Show published or all
     *
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function paginate($page = 1, $limit = 10, $all = false, $notLazy = false) {
        $result = new \StdClass();
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        $query = $this->tagRealEstale;

        $tagRealEstales = $query->skip($limit * ($page - 1))
                ->take($limit)
                ->get();

        $result->totalItems = $this->totalTagRealEstales();
        $result->items = $tagRealEstales->all();

        return $result;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id) {
        $this->tagRealEstale = $this->tagRealEstale->findOrFail($id);

        return $this->tagRealEstale;
    }

    /**
     * @param $attributes
     *
     * @return bool|mixed
     *
     * @throws \Fully\Exceptions\Validation\ValidationException
     */
    public function create($attributes) {
        try {
            $this->tagRealEstale->fill($attributes)->save();
            return true;
        } catch (Exception $e) {
            throw new ValidationException('tagRealEstale validation failed', $this->getErrors());
        }
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
        $this->tagRealEstale = $this->find($id);
        try {
            $this->tagRealEstale->fill($attributes);
            $this->tagRealEstale->resluggify();
            $this->tagRealEstale->save();
            return true;
        } catch (Exception $e) {
            throw new ValidationException('Tag Real Estale validation failed', $this->getErrors());
        }
    }

    /**
     * @param $id
     *
     * @return mixed|void
     */
    public function delete($id) {
        $tagRealEstale = $this->tagRealEstale->find($id);
        $tagRealEstale->delete();
    }

    /**
     * Get total tag count.
     *
     * @return mixed
     */
    protected function totalTagRealEstales() {
        return $this->tagRealEstale->count();
    }

    public function getTagParent() {
        return $this->tagRealEstale->where('tag_parent_id', 0)->select('id', 'name')->get();
    }

    public function getTagParentFrontend() {
        return $this->tagRealEstale->where('tag_parent_id', 0)->get();
    }
    
    public function getTagBySlug($slug) {
        return $this->tagRealEstale->where('slug', $slug)->first();
    }
    
}
