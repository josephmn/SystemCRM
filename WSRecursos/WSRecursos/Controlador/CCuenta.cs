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
    public class CCuenta
    {
        public List<ECuenta> Listar_Cuenta(SqlConnection con)
        {
            List<ECuenta> lECuenta = null;
            SqlCommand cmd = new SqlCommand("ASP_CUENTA", con);
            cmd.CommandType = CommandType.StoredProcedure;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lECuenta = new List<ECuenta>();

                ECuenta obECuenta = null;
                while (drd.Read())
                {
                    obECuenta = new ECuenta();
                    obECuenta.i_id = drd["i_id"].ToString();
                    obECuenta.v_descripcion = drd["v_descripcion"].ToString();
                    obECuenta.v_default = drd["v_default"].ToString();
                    lECuenta.Add(obECuenta);
                }
                drd.Close();
            }

            return (lECuenta);
        }
    }
}