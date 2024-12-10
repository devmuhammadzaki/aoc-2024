const std = @import("std");
const mem = std.mem;
const assert = std.debug.assert;

pub fn main() !void {
    const p1, const p2 = comptime blk: {
        @setEvalBranchQuota(500_000);
        const input = @embedFile("input.txt");
        var iter = std.mem.tokenizeAny(u8, input, &std.ascii.whitespace);
        var lrs: [2][]const u32 = .{ &.{}, &.{} };

        var i: u1 = 0;
        while (iter.next()) |num| : (i +%= 1) {
            lrs[i] = lrs[i] ++ .{try std.fmt.parseInt(u32, num, 10)};
        }

        var lefts = lrs[0][0..].*;
        var rights = lrs[1][0..].*;

        std.mem.sortUnstable(u32, &lefts, {}, std.sort.asc(u32));
        std.mem.sortUnstable(u32, &rights, {}, std.sort.asc(u32));

        var sum1: u32 = 0;
        var sum2: u32 = 0;
        var ridx: u32 = 0;
        for (lefts, rights) |l, r| {
            const li: i32 = @bitCast(l);
            const ri: i32 = @bitCast(r);
            sum1 += @abs(li - ri);

            var count: u32 = 0;
            for (rights[ridx..]) |r1| {
                if (r1 > l) break;
                count += @intFromBool(l == r1);
                ridx += 1;
            }
            sum2 += l * count;
        }

        break :blk .{ sum1, sum2 };
    };

    const p1_expected = 1530215;
    std.debug.print("Total Difference: {}, Pass: {}\n", .{ p1, p1 == p1_expected });

    const p2_expected = 26800609;
    std.debug.print("Total Similarity Score: {}, Pass: {}\n", .{ p2, p2 == p2_expected });
}
