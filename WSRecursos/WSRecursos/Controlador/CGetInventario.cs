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
    public class CGetInventario
    {
        public List<EGetInventario> GetInventario(SqlConnection con)
        {
            List<EGetInventario> lEGetInventario = null;
            SqlCommand cmd = new SqlCommand("ASP_INVENTARIO", con);
            cmd.CommandType = CommandType.StoredProcedure;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEGetInventario = new List<EGetInventario>();

                EGetInventario obEGetInventario = null;
                while (drd.Read())
                {
                    obEGetInventario = new EGetInventario();
                    obEGetInventario.v_sku = drd["v_sku"].ToString();
                    obEGetInventario.v_descripcion = drd["v_descripcion"].ToString();
                    lEGetInventario.Add(obEGetInventario);
                }
                drd.Close();
            }

            return (lEGetInventario);
        }
    }
}