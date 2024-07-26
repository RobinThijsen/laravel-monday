<?php
// TODO BIG3 parent method getItems() and getMe()

namespace RobinThijsen\LaravelMonday;

use RobinThijsen\LaravelMonday\Objects\MondayAccount;
use RobinThijsen\LaravelMonday\Objects\MondayBlock;
use RobinThijsen\LaravelMonday\Objects\MondayBoard;
use RobinThijsen\LaravelMonday\Objects\MondayColumn;
use RobinThijsen\LaravelMonday\Objects\MondayColumnValue;
use RobinThijsen\LaravelMonday\Objects\MondayDoc;
use RobinThijsen\LaravelMonday\Objects\MondayGroup;
use RobinThijsen\LaravelMonday\Objects\MondayIcon;
use RobinThijsen\LaravelMonday\Objects\MondayItem;
use RobinThijsen\LaravelMonday\Objects\MondayItemPage;
use RobinThijsen\LaravelMonday\Objects\MondayWorkspace;
use RobinThijsen\LaravelMonday\Exceptions\ChainedNotAllowException;
use RobinThijsen\LaravelMonday\Exceptions\InvalidTokenException;

class QueryBuilder extends LaravelMonday
{
    private string $query;

    /**
     * Init a query.
     */
    public static function query(): self
    {
        return new self;
    }

    /**
     * Init a doc(s) query.<br/>
     * See list of fields available in the Doc Model<br/>
     * See list of attributes available in the Doc Model
     *
     * @return $this
     */
    public function getDocs(array|string $arguments = MondayDoc::ARGUMENTS, array|string $fields = MondayDoc::FIELDS): self
    {
        $this->query = 'docs (';

        // attributes
        foreach ($arguments as $key => $value) {
            if (! is_null($value)) {
                $this->query .= "{$key}: {$value}, ";
            }
        }

        // remove last ", "
        $this->query = substr_replace($this->query, ') { ', -2);

        // fields
        $this->query .= implode(" ", $fields) . ' ';

        return $this;
    }

    /**
     * Init a boards(s) query.<br/>
     * See list of fields available in the Board Model<br/>
     * See list of attributes available in the Board Model
     *
     * @return $this
     */
    public function getBoards(array|string $arguments = MondayBoard::ARGUMENTS, array|string $fields = MondayBoard::FIELDS): self
    {
        $this->query = 'boards (';

        // attributes
        foreach ($arguments as $key => $value) {
            if (! is_null($value)) {
                $this->query .= "{$key}: {$value}, ";
            }
        }

        // remove last ", "
        $this->query = substr_replace($this->query, ') { ', -2);

        // fields
        $this->query .= implode(" ", $fields) . ' ';

        return $this;
    }

    /**
     * Init a workspaces(s) query.<br/>
     * See list of fields available in the Workspace Model<br/>
     * See list of attributes available in the Workspace Model
     *
     * @return $this
     */
    public function getWorkspaces(array|string $arguments = MondayWorkspace::ARGUMENTS, array|string $fields = MondayWorkspace::FIELDS): self
    {
        $this->query = 'workspaces (';

        // attributes
        foreach ($arguments as $key => $value) {
            if (! is_null($value)) {
                $this->query .= "{$key}: {$value}, ";
            }
        }

        // remove last ", "
        $this->query = substr_replace($this->query, ') { ', -2);

        // fields
        $this->query .= implode(" ", $fields) . ' ';

        return $this;
    }

    /**
     * Init a items(s) query. <br/>
     * See list of fields available in the Item Model <br/>
     * See list of attributes available in the Item Model
     *
     * @param array $arguments
     * @param array $fields
     * @return $this
     */
    public function getItems(array $arguments = MondayItem::ARGUMENTS, array $fields = MondayItem::FIELDS): self
    {
        $this->query = 'items (';

        // attributes
        foreach ($arguments as $key => $value) {
            if (! is_null($value)) {
                $this->query .= "{$key}: {$value}, ";
            }
        }

        // remove last ", "
        $this->query = substr_replace($this->query, ') { ', -2);

        // fields
        $this->query .= implode(" ", $fields) . ' ';

        return $this;
    }

    /**
     * Build a owners_subscribers query.<br/>
     * Only available on workspaces query.
     *
     * @return $this
     *
     * @throws ChainedNotAllowException
     */
    public function ownersSubscribers(array $fields = MondayAccount::FIELDS): self
    {
        if (! str_contains($this->query, 'workspaces')) {
            throw new ChainedNotAllowException('Chained method ownersSubscribers() is only allowed on workspaces query.');
        }

        $this->query .= 'owners_subscribers { '.implode(' ', $fields).' } ';

        return $this;
    }

    /**
     * Build a users_subscribers query.<br/>
     * Only available on workspaces query.
     *
     * @return $this
     *
     * @throws ChainedNotAllowException
     */
    public function usersSubscribers(array $fields = MondayAccount::FIELDS): self
    {
        if (! str_contains($this->query, 'workspaces')) {
            throw new ChainedNotAllowException('Chained method usersSubscribers() is only allowed on workspaces query.');
        }

        $this->query .= 'users_subscribers { '.implode(' ', $fields).' } ';

        return $this;
    }

    /**
     * Build a blocks query.<br/>
     * Only available on docs query.
     *
     * @return $this
     *
     * @throws ChainedNotAllowException
     */
    public function blocks(array|string $arguments = MondayBlock::ARGUMENTS, array|string $fields = MondayBlock::FIELDS): self
    {
        if (! str_contains($this->query, 'docs')) {
            throw new ChainedNotAllowException('Chained method blocks() is only allowed on docs query.');
        }

        $this->query .= 'blocks (';

        // attributes
        foreach ($arguments as $key => $value) {
            if (! is_null($value)) {
                $this->query .= "{$key}: {$value}, ";
            }
        }

        // remove last ", "
        $this->query = substr_replace($this->query, ') { ', -2);

        // fields
        $this->query .= implode(" ", $fields) . " ";

        return $this;
    }

    /**
     * Build a creator query.
     *
     * @return $this
     */
    public function creator(array $fields = MondayAccount::FIELDS): self
    {
        if (str_contains($this->query, 'boards') || str_contains($this->query, 'items')) {
            $this->query .= 'creator { '.implode(' ', $fields).' } ';
        } elseif (str_contains($this->query, 'docs') || str_contains($this->query, 'blocks')) {
            $this->query .= 'created_by { '.implode(' ', $fields).' } ';
        }

        return $this;
    }

    /**
     * Build an owners query.<br/>
     * Only available on boards query.
     *
     * @return $this
     *
     * @throws ChainedNotAllowException
     */
    public function owners(array $fields = MondayAccount::FIELDS): self
    {
        if (! str_contains($this->query, 'boards')) {
            throw new ChainedNotAllowException('Chained method owners() is only allowed on boards query.');
        }

        $this->query .= 'owners { '.implode(' ', $fields).' } ';

        return $this;
    }

    /**
     * Build a subscribers query.<br/>
     * Only available on boards query.
     *
     * @return $this
     *
     * @throws ChainedNotAllowException
     */
    public function subscribers(array $fields = MondayAccount::FIELDS): self
    {
        if (! str_contains($this->query, 'boards') || ! str_contains($this->query, 'items')) {
            throw new ChainedNotAllowException('Chained method subscribers() is only allowed on boards and items query.');
        }

        $this->query .= 'subscribers { '.implode(' ', $fields).' } ';

        return $this;
    }

    /**
     * Build a columns query.<br/>
     * Only available on boards query.
     *
     * @return $this
     *
     * @throws ChainedNotAllowException
     */
    public function columns(array $fields = MondayColumn::FIELDS): self
    {
        if (! str_contains($this->query, 'boards')) {
            throw new ChainedNotAllowException('Chained method columns() is only allowed on boards query.');
        }

        $this->query .= 'columns { '.implode(' ', $fields).' } ';

        return $this;
    }

    /**
     * Build a column_values query.<br/>
     * Only available on items query.
     *
     * @param array $arguments
     * @param array $fields
     * @return $this
     * @throws ChainedNotAllowException
     */
    public function columnValues(array $arguments = MondayColumnValue::ARGUMENTS, array $fields = MondayColumnValue::FIELDS): self
    {
        if (! str_contains($this->query, 'items')) {
            throw new ChainedNotAllowException('Chained method columnValues() is only allowed on items query.');
        }

        $this->query .= 'column_values ';

        if (!empty($arguments)) {
            $this->query .= "(";

            foreach ($arguments as $key => $value) {
                if (!is_null($value)) {
                    $this->query .= "{$key}: ";
                    if (is_array($value)) {
                        if ($key == "ids") {
                            $this->query .= "{$key}: [" . '"' . implode('", "', $value) . '"' . "], ";
                        } else {
                            $this->query .= "{$key}: [" . implode(", ", $value) . "], ";
                        }
                    } else {
                        if ($key == "ids") {
                            $this->query .= $key . ': "' . $value . '", ';
                        } else {
                            $this->query .= "{$key}: {$value}";
                        }
                    }
                }
            }

            $this->query = substr_replace($this->query, ") { ", -2);
        }

        $this->query .= implode(" ", $fields) . ' ';

        return $this;
    }

    /**
     * Build a workspace query.<br/>
     * Only available on boards and docs query.
     *
     * @return $this
     *
     * @throws ChainedNotAllowException
     */
    public function workspace(array $fields = MondayWorkspace::FIELDS): self
    {
        if (! str_contains($this->query, 'boards') || ! str_contains($this->query, 'docs')) {
            throw new ChainedNotAllowException('Chained method workspace() is only allowed on boards and docs query.');
        }

        $this->query .= 'workspace { '.implode(' ', $fields).' } ';

        return $this;
    }

    /**
     * Build a groups query.<br/>
     * Only available on boards query.
     *
     * @param array $fields
     * @return $this
     * @throws ChainedNotAllowException
     */
    public function groups(array|string $ids = null, array $fields = MondayGroup::FIELDS): self
    {
        if (! str_contains($this->query, 'boards')) {
            throw new ChainedNotAllowException('Chained method groups() is only allowed on boards query.');
        }

        $this->query .= "groups ";

        if (! is_null($ids)) {
            $this->query .= "(ids: ";

            foreach ($ids as $id) {
                if (!is_null($id)) {
                    $this->query .= '"'.$id.'", ';
                }
            }

            $this->query = substr_replace($this->query, ") { ", -2);
        } else {
            $this->query .= "{ ";
        }

        $this->query .= implode(' ', $fields) . ' ';

        return $this;
    }

    /**
     * Build a top_group query.<br/>
     * Only available on boards query.
     *
     * @param array $fields
     * @return $this
     * @throws ChainedNotAllowException
     */
    public function topGroup(array $fields = MondayGroup::FIELDS): self
    {
        if (! str_contains($this->query, 'boards')) {
            throw new ChainedNotAllowException('Chained method topGroup() is only allowed on boards query.');
        }

        $this->query .= 'top_group { '.implode(' ', $fields).' } ';

        return $this;
    }

    /**
     * Build a items query.<br/>
     * Only available on boards query.
     *
     * @param array $fields
     * @return $this
     * @throws ChainedNotAllowException
     */
    public function items(array $fields = MondayItem::FIELDS): self
    {
        if (! str_contains($this->query, 'boards')) {
            throw new ChainedNotAllowException('Chained method items() is only allowed on boards query.');
        }

        $this->query .= 'items_page { items { '.implode(' ', $fields).' ';

        return $this;
    }

    /**
     * Build a group query.<br/>
     * Only available on items query.
     *
     * @param array $fields
     * @return $this
     * @throws ChainedNotAllowException
     */
    public function board(array $fields = MondayBoard::FIELDS): self
    {
        if (!str_contains($this->query, 'items')) {
            throw new ChainedNotAllowException('Chained method board() is only allowed on items query.');
        }

        $this->query .= 'board { ' . implode(' ', $fields) . ' } ';

        return $this;
    }

    /**
     * Build a group query.<br/>
     * Only available on items query.
     *
     * @param array $fields
     * @return $this
     * @throws ChainedNotAllowException
     */
    public function parentItem(array $fields = MondayItem::FIELDS): self
    {
        if (!str_contains($this->query, 'boards') && !str_contains($this->query, 'items')) {
            throw new ChainedNotAllowException('Chained method parentItem() is only allowed on items query.');
        }

        $this->query .= 'parent_item { '.implode(' ', $fields).' } ';

        return $this;
    }

    /**
     * Build a group query.<br/>
     * Only available on items query.
     *
     * @param array $fields
     * @return $this
     * @throws ChainedNotAllowException
     */
    public function subitems(array $fields = MondayItem::FIELDS): self
    {
        if (!str_contains($this->query, 'boards') && !str_contains($this->query, 'items')) {
            throw new ChainedNotAllowException('Chained method subitems() is only allowed on items query.');
        }

        $this->query .= 'subitems { '.implode(' ', $fields).' } ';

        return $this;
    }

    /**
     * Build a group query.<br/>
     * Only available on items query.
     *
     * @param array $fields
     * @return $this
     * @throws ChainedNotAllowException
     */
    public function group(array $fields = MondayGroup::FIELDS): self
    {
        if (!str_contains($this->query, 'boards') && !str_contains($this->query, 'items')) {
            throw new ChainedNotAllowException('Chained method group() is only allowed on items query.');
        }

        $this->query .= 'group { '.implode(' ', $fields).' } ';

        return $this;
    }

    /**
     * Build a settings query.<br/>
     * Only available on workspaces query.
     *
     * @return $this
     *
     * @throws ChainedNotAllowException
     */
    public function settings(): self
    {
        if (! str_contains($this->query, 'workspaces')) {
            throw new ChainedNotAllowException('Chained method settings() is only allowed on workspaces query.');
        }

        $this->query .= 'settings { ';

        return $this;
    }

    /**
     * Build a icon query.<br/>
     * Only available on settings query.
     *
     * @return $this
     *
     * @throws ChainedNotAllowException
     */
    public function icon(array $fields = MondayIcon::FIELDS): self
    {
        if (! str_contains($this->query, 'settings') || ! str_contains($this->query, 'workspaces')) {
            throw new ChainedNotAllowException('Chained method icon() is only allowed on settings and workspaces query.');
        }

        $this->query .= 'icon { '.implode(' ', $fields).' } ';

        return $this;
    }

    /**
     * End the query.
     */
    public function end(): void
    {
        $openBraquetCount = substr_count($this->query, '{');
        $closeBraquetCount = substr_count($this->query, '}');

        for ($i = 1; $i <= ($openBraquetCount - $closeBraquetCount); $i++) {
            $this->query .= '} ';
        }

        $this->query = substr_replace($this->query, '', -1);
    }

    /**
     * @return QueryResult
     * @throws InvalidTokenException
     */
    public function get(): QueryResult
    {
        $this->end();
        dd($this->query);
        return parent::queryResult($this->query);
    }
}
