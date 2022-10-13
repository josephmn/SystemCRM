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
    public class CCargo
    {
        public List<ECargo> Listar_Cargo(SqlConnection con)
        {
            List<ECargo> lECargo = null;
            SqlCommand cmd = new SqlCommand("ASP_CONSULTAR_CARGO", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lECargo = new List<ECargo>();

                ECargo obECargo = null;
                while (drd.Read())
                {
                    obECargo = new ECargo();
                    obECargo.i_id = drd["i_id"].ToString();
                    obECargo.v_descripcion = drd["v_descripcion"].ToString();
                    obECargo.v_default = drd["v_default"].ToString();
                    lECargo.Add(obECargo);
                }
                drd.Close();
            }

            return (lECargo);
        }
    }
}