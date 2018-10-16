<?php

namespace App\Presenters;

use App\Transformers\AdminUserRoleTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AdminUserRolePresenter
 *
 * @package namespace App\Presenters;
 */
class AdminUserRolePresenter extends FractalPresenter
{

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AdminUserRoleTransformer();
    }


}
