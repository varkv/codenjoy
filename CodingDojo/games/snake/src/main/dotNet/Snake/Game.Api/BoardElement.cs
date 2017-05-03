/*-
 * #%L
 * Codenjoy - it's a dojo-like platform from developers to developers.
 * %%
 * Copyright (C) 2016 Codenjoy
 * %%
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public
 * License along with this program.  If not, see
 * <http://www.gnu.org/licenses/gpl-3.0.html>.
 * #L%
 */
﻿namespace Game.Api
{
    public enum BoardElement : short
    {
        BadApple = (short)'☻',
		GoodApple = (short)'☺',

		Break = (short)'☼',

		HeadDown = (short)'▼',
		HeadLeft = (short)'◄',
		HeadRight = (short)'►',
		HeadUp = (short)'▲',

		TailEndDown = (short)'╙',
		TailEndLeft = (short)'╘',
		TailEndUp = (short)'╓',
		TailEndRight = (short)'╕',
		TailHorizontal = (short)'═',
		TailVertical = (short)'║',
		TailLeftDown = (short)'╗',
		TailLeftUp = (short)'╝',
		TailRightDown = (short)'╔',
		TailRightUp = (short)'╚',

		None = (short)' '         
    }
}