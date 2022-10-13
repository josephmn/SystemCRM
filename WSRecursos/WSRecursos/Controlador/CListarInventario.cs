using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CListarInventario
    {
        public List<EListarInventario> ListarInventario(SqlConnection con, Int32 post, String sku)
        {
            List<EListarInventario> lEListarInventario = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_INVENTARIO", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@sku", SqlDbType.VarChar).Value = sku;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarInventario = new List<EListarInventario>();

                EListarInventario obEListarInventario = null;
                while (drd.Read())
                {
                    obEListarInventario = new EListarInventario();
                    obEListarInventario.i_id = Convert.ToInt32(drd["i_id"].ToString());
                    obEListarInventario.v_sku = drd["v_sku"].ToString();
                    obEListarInventario.v_descripcion = drd["v_descripcion"].ToString();
                    obEListarInventario.v_marca = drd["v_marca"].ToString();
                    obEListarInventario.f_precio = Convert.ToDouble(drd["f_precio"].ToString());
                    obEListarInventario.i_estado = Convert.ToInt32(drd["i_estado"].ToString());
                    obEListarInventario.v_estado = drd["v_estado"].ToString();
                    obEListarInventario.v_color_estado = drd["v_color_estado"].ToString();
                    obEListarInventario.d_fregistro = drd["d_fregistro"].ToString();
                    obEListarInventario.d_factualiza = drd["d_factualiza"].ToString();
                    lEListarInventario.Add(obEListarInventario);
                }
                drd.Close();
            }

            return (lEListarInventario);
        }
    }
}