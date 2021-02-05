<?php

declare(strict_types=1);

namespace Shlinkio\Shlink\Core\ShortUrl\Helper;

use Shlinkio\Shlink\Core\Util\UrlValidatorInterface;

class ShortUrlTitleResolutionHelper implements ShortUrlTitleResolutionHelperInterface
{
    private UrlValidatorInterface $urlValidator;

    public function __construct(UrlValidatorInterface $urlValidator)
    {
        $this->urlValidator = $urlValidator;
    }

    public function processTitleAndValidateUrl(TitleResolutionModelInterface $data): TitleResolutionModelInterface
    {
        if ($data->hasTitle()) {
            $this->urlValidator->validateUrl($data->getLongUrl(), $data->doValidateUrl());
            return $data;
        }

        $title = $this->urlValidator->validateUrlWithTitle($data->getLongUrl(), $data->doValidateUrl());
        return $title === null ? $data : $data->withResolvedTitle($title);
    }
}
