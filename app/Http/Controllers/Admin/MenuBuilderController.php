<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuBuilderController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::all();
        $selectedMenu = null;
        $menuItems = collect();
        $allMenuItems = collect();

        if ($request->has('menu_id')) {
            $selectedMenu = Menu::findOrFail($request->menu_id);
            $menuItems = MenuItem::where('menu_id', $selectedMenu->id)
                ->where('parent_id', 0)
                ->orderBy('sort')
                ->get();
            $allMenuItems = MenuItem::where('menu_id', $selectedMenu->id)->get();
        } elseif ($menus->isNotEmpty()) {
            return redirect()->route('admin.menus.index', ['menu_id' => $menus->first()->id]);
        }

        return view('admin.menu-builder.index', compact('menus', 'selectedMenu', 'menuItems', 'allMenuItems'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:menus,name']);
        $menu = Menu::create($request->only('name'));

        return redirect()->route('admin.menus.index', ['menu_id' => $menu->id])
            ->with([
                'message' => 'Menu created successfully!',
                'alert-type' => 'success'
            ]);
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate(['name' => 'required|string|max:255|unique:menus,name,' . $menu->id]);
        $menu->update($request->only('name'));

        return back()->with([
            'message' => 'Menu updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('admin.menus.index')->with([
            'message' => 'Menu deleted successfully!',
            'alert-type' => 'success'
        ]);
    }

    // --- Menu Items Methods ---

    public function storeItem(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'label'   => 'required|string|max:255',
            'link'    => 'required|string|max:255',
            'parent_id' => 'nullable|integer'
        ]);

        MenuItem::create([
            'menu_id'   => $request->menu_id,
            'label'     => $request->label,
            'link'      => $request->link,
            'target'    => $request->target ?? '_self',
            'class'     => $request->class,
            'icon'      => $request->icon,
            'status'    => $request->status ?? 1,
            'parent_id' => $request->parent_id ?? 0,
            'sort'      => MenuItem::where('menu_id', $request->menu_id)->max('sort') + 1,
        ]);

        return back()->with([
            'message' => 'Menu item added successfully!',
            'alert-type' => 'success'
        ]);
    }

    public function updateItem(Request $request, MenuItem $item)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'link'  => 'required|string|max:255',
            'parent_id' => 'nullable|integer'
        ]);

        $item->update($request->only(['label', 'link', 'target', 'class', 'icon', 'status', 'parent_id']));

        return back()->with([
            'message' => 'Menu item updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    public function destroyItem(MenuItem $item)
    {
        MenuItem::where('parent_id', $item->id)->delete();
        $item->delete();

        return back()->with([
            'message' => 'Menu item deleted successfully!',
            'alert-type' => 'success'
        ]);
    }

    public function sortItems(Request $request)
    {
        $items = json_decode($request->get('order'), true);
        $this->updateSortOrder($items, 0, 0);

        return response()->json(['status' => 'success', 'message' => 'Menu order updated successfully!']);
    }

    private function updateSortOrder($items, $parentId, $depth)
    {
        foreach ($items as $index => $item) {
            MenuItem::where('id', $item['id'])->update([
                'sort'      => $index,
            ]);

            if (isset($item['children'])) {
                $this->updateSortOrder($item['children'], $item['id'], $depth + 1);
            }
        }
    }
}
